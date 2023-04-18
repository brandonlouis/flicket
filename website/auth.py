from flask import Blueprint, render_template, request, flash, redirect, url_for
from .models import User
from werkzeug.security import generate_password_hash, check_password_hash
from . import db   ##means from __init__.py import db
from flask_login import login_user, login_required, logout_user, current_user

auth = Blueprint('auth', __name__)

@auth.route('/login', methods=['GET', 'POST']) # Handle requests for login page
def login():
    if current_user.is_authenticated: # Prevent logged in users from accessing login page
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            loginEmail = request.form.get('loginEmail')
            loginPassword = request.form.get('loginPassword')

            user = User.query.filter_by(email=loginEmail).first()
            if user:
                if check_password_hash(user.password, loginPassword):
                    flash('Logged in successfully. Welcome, ' + user.fullName + '!', category='success')
                    login_user(user, remember=True)
                    return redirect(url_for('views.home'))
                else:
                    flash('Incorrect password, please try again', category='error')
            else:
                flash('Email does not exist', category='error')

    return render_template("login.html", user=current_user)


@auth.route('/logout') # Handle logout request
@login_required
def logout():
    logout_user()
    flash('Logged out successfully!', category='success')
    return redirect(url_for('views.home'))


@auth.route('/register', methods=['GET', 'POST']) # Handle requests for register page
def register():
    if current_user.is_authenticated: # Prevent logged in users from accessing register page
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            fullName = request.form.get('fullName')
            email = request.form.get('email')
            phoneNo = request.form.get('phoneNo')
            password1 = request.form.get('password1')
            password2 = request.form.get('password2')

            user = User.query.filter_by(email=email).first() # Check if email already exists
            if user:
                flash('Email already exists', category='error')
            elif "@flicket.com" in email.lower():
                flash('Invalid email address', category='error')
            elif password1 != password2:
                flash('Passwords do not match', category='error')
            else:
                new_user = User(userType="customer", fullName=fullName, email=email, phoneNo=phoneNo, password=generate_password_hash(password2, method='sha256'))
                db.session.add(new_user)

                db.session.commit()
                login_user(new_user, remember=True)
                flash('Account created. Welcome, ' + new_user.fullName + '!', category='success')
                return redirect(url_for('views.home'))

            # # CREATION OF DUMMY DB ATTRIBUTES FOR 4 ACTORS 
            # # comment out line 46 to 60 and run, fill up the form randomly and click 'Register an account'
            # new_user1 = User(userType="userAdmin", fullName="Adam Tan", email="adamTan@flicket.com", phoneNo="91234567", password=generate_password_hash("123qwe", method='sha256'))
            # new_user2 = User(userType="employee", fullName="Bob Ng", email="bobNg@flicket.com", phoneNo="98765432", password=generate_password_hash("123qwe", method='sha256'))
            # new_user3 = User(userType="cinemaOwner", fullName="Caroline Jacobs", email="carolineJ@flicket.com", phoneNo="98761234", password=generate_password_hash("123qwe", method='sha256'))
            # new_user4 = User(userType="customer", fullName="Zion Faries", email="zionF@gmail.com", phoneNo="91238765", password=generate_password_hash("123qwe", method='sha256'))
            # db.session.add(new_user1)
            # db.session.add(new_user2)
            # db.session.add(new_user3)
            # db.session.add(new_user4)
            # db.session.commit()

    return render_template("register.html", user=current_user)