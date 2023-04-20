from flask import Blueprint, render_template, request, flash, redirect, url_for
from .models import Account
from werkzeug.security import generate_password_hash, check_password_hash
from . import db
from flask_login import login_user, login_required, logout_user, current_user

auth = Blueprint('auth', __name__)

@auth.route('/login', methods=['GET', 'POST']) # Handle requests for login page
def login():
    if current_user.is_authenticated: # Prevent logged in users from accessing login page
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            loginEmail = request.form.get('loginEmail').lower()
            loginPassword = request.form.get('loginPassword')

            account = Account.query.filter_by(email=loginEmail).first()
            if account:
                if check_password_hash(account.password, loginPassword):
                    flash('Logged in successfully. Welcome, ' + account.fullName + '!', category='success')
                    login_user(account, remember=True)
                    return redirect(url_for('views.home'))
                else:
                    flash('Incorrect password, please try again', category='error')
            else:
                flash('Email does not exist', category='error')

    return render_template("login.html", account=current_user)


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
            email = request.form.get('email').lower()
            phoneNo = request.form.get('phoneNo')
            password1 = request.form.get('password1')
            password2 = request.form.get('password2')

            account = Account.query.filter_by(email=email).first() # Check if email already exists
            if account:
                flash('Email already exists', category='error')
            elif "@flicket.com" in email.lower():
                flash('Invalid email address', category='error')
            elif password1 != password2:
                flash('Passwords do not match', category='error')
            else:
                new_account = Account(userType="customer", fullName=fullName, email=email, phoneNo=phoneNo, password=generate_password_hash(password2, method='sha256'))
                db.session.add(new_account)

                db.session.commit()
                login_user(new_account, remember=True)
                flash('Account created. Welcome, ' + new_account.fullName + '!', category='success')
                return redirect(url_for('views.home'))

            # # CREATION OF DUMMY DB ATTRIBUTES FOR 4 ACTORS 
            # # comment out line 46 to 66 and run, fill up the form randomly and click 'Register an account'
            # new_account1 = Account(userType="userAdmin", fullName="Adam Tan", email="adamtan@flicket.com", phoneNo="91234567", password=generate_password_hash("123qwe", method='sha256'))
            # new_account2 = Account(userType="employee", fullName="Bob Ng", email="bobng@flicket.com", phoneNo="98765432", password=generate_password_hash("123qwe", method='sha256'))
            # new_account3 = Account(userType="cinemaOwner", fullName="Caroline Jacobs", email="carolinej@flicket.com", phoneNo="98761234", password=generate_password_hash("123qwe", method='sha256'))
            # new_account4 = Account(userType="customer", fullName="Zion Faries", email="zionf@gmail.com", phoneNo="91238765", password=generate_password_hash("123qwe", method='sha256'))
            # db.session.add(new_account1)
            # db.session.add(new_account2)
            # db.session.add(new_account3)
            # db.session.add(new_account4)
            # db.session.commit()

    return render_template("register.html", account=current_user)