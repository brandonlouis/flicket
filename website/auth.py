from flask import Blueprint, render_template, request, flash, redirect, url_for
from .models import Account, Profile
from werkzeug.security import generate_password_hash, check_password_hash
from . import db
from flask_login import login_user, login_required, logout_user, current_user

auth = Blueprint('auth', __name__)

# LOGIN/LOGOUT/REGISTER LOGIN/LOGOUT/REGISTER LOGIN/LOGOUT/REGISTER LOGIN/LOGOUT/REGISTER LOGIN/LOGOUT/REGISTER
@auth.route('/login', methods=['GET', 'POST']) # LOGIN
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

    return render_template("loginRegister/login.html", account=current_user)

@auth.route('/register', methods=['GET', 'POST'])  # REGISTER
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
                new_profile = Profile(profileName=fullName, account=new_account)
                db.session.add(new_account, new_profile)

                db.session.commit()
                login_user(new_account, remember=True)
                flash('Account created. Welcome, ' + new_account.fullName + '!', category='success')
                return redirect(url_for('views.home'))

        # # CREATION OF DUMMY DB ATTRIBUTES FOR 4 ACTORS 
        # # comment out line 45 to 66 and enter registration page, accounts will be created in db on page load
        # new_accounts = [
        #     Account(userType="userAdmin", fullName="Adam Tan", email="adamtan@flicket.com", phoneNo="91234567", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="userAdmin", fullName="Alicia Mark", email="aliciam@flicket.com", phoneNo="81234567", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="cinemaManager", fullName="Bob Ng", email="bobng@flicket.com", phoneNo="98765432", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="cinemaManager", fullName="Bala Gonzales", email="balag@flicket.com", phoneNo="88765432", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="cinemaOwner", fullName="Caroline Jacobs", email="carolinej@flicket.com", phoneNo="98761234", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="cinemaOwner", fullName="Calvin Klein", email="calvink@flicket.com", phoneNo="88761234", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="customer", fullName="Zion Faries", email="zionf@gmail.com", phoneNo="91238765", password=generate_password_hash("123qwe", method='sha256')),
        #     Account(userType="customer", fullName="Zac Efron", email="zacE@hotmail.com", phoneNo="81238765", password=generate_password_hash("123qwe", method='sha256'))
        # ]
        # new_profiles = [
        #     Profile(profileName="AdamTanzaniteFR", account=new_accounts[0]),
        #     Profile(profileName="AMark435099", account=new_accounts[1]),
        #     Profile(profileName="BobTheBuilder", account=new_accounts[2]),
        #     Profile(profileName="BalGon87", account=new_accounts[3]),
        #     Profile(profileName="CYakob", account=new_accounts[4]),
        #     Profile(profileName="Kleinman942", account=new_accounts[5]),
        #     Profile(profileName="ZionF4U", account=new_accounts[6]),
        #     Profile(profileName="HighSchMusical2", account=new_accounts[7])
        # ]
        # for new_account in new_accounts:
        #     db.session.add(new_account)
        # for new_profile in new_profiles:
        #     db.session.add(new_profile)
        # db.session.commit()

    return render_template("loginRegister/register.html", account=current_user)

@auth.route('/logout') # LOGOUT
@login_required
def logout():
    logout_user()
    flash('Logged out successfully!', category='success')
    return redirect(url_for('views.home'))





# ACCOUNT MANAGEMENT ACCOUNT MANAGEMENT ACCOUNT MANAGEMENT ACCOUNT MANAGEMENT ACCOUNT MANAGEMENT 
@auth.route('/manageAccounts') # RETRIEVE ACCOUNTS
@login_required
def manageAccounts():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        accounts = Account.query.order_by(Account.id.asc()).all()

    return render_template("account/manageAccounts.html", accounts=accounts, account=current_user)

@auth.route('/createAccount', methods=['GET', 'POST']) # CREATE ACCOUNTS
@login_required
def createAccount():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            userType = request.form.get('userType')
            fullName = request.form.get('fullName')
            email = request.form.get('email').lower()
            phoneNo = request.form.get('phoneNo')
            password1 = request.form.get('password1')
            password2 = request.form.get('password2')

            account = Account.query.filter_by(email=email).first() # Check if email already exists
            if account:
                flash('Email already exists', category='error')
            elif password1 != password2:
                flash('Passwords do not match', category='error')
            elif userType != "customer" and "@flicket.com" not in email.lower(): # Only allow emails with "@flicket.com" to be assigned with organizational roles 
                flash('Email has to contain "@flicket.com" for organizational roles', category='error')
            elif userType == "customer" and "@flicket.com" in email.lower(): # Only allow emails without "@flicket.com" to be assigned as "customer"
                flash('"customer" user type cannot contain "@flicket.com" in the email', category='error')
            else:
                new_account = Account(userType=userType, fullName=fullName, email=email, phoneNo=phoneNo, password=generate_password_hash(password2, method='sha256'))
                new_profile = Profile(profileName=fullName, account=new_account)
                db.session.add(new_account, new_profile)
                db.session.commit()

                flash('Account successfully created!', category='success')
                return redirect(url_for('auth.manageAccounts'))
    return render_template("account/createAccount.html", account=current_user)

@auth.route('/editAccount/<int:id>', methods=['GET', 'POST']) # UPDATE ACCOUNT
@login_required
def editAccount(id):
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        accountDetails = Account.query.filter_by(id=id).first() # Get account details to pre-populate form

        if request.method == 'POST':
            userType = request.form.get('userType')
            fullName = request.form.get('fullName')
            email = request.form.get('email').lower()
            phoneNo = request.form.get('phoneNo')
            nPassword1 = request.form.get('nPassword1')
            nPassword2 = request.form.get('nPassword2')

            if nPassword1 != nPassword2:
                flash('Passwords do not match', category='error')
            elif userType != "customer" and "@flicket.com" not in email.lower(): # Only allow emails with "@flicket.com" to be assigned organizational roles 
                flash('Email has to contain "@flicket.com" for organizational roles', category='error')
            elif userType == "customer" and "@flicket.com" in email.lower(): # Only allow emails without "@flicket.com" to be assigned as "customer"
                flash('Customer\'s email must not contain "@flicket.com"', category='error')
            else:
                accountDetails.userType = userType
                accountDetails.fullName = fullName
                accountDetails.email = email
                accountDetails.phoneNo = phoneNo
                if (not nPassword1 and not nPassword2) or (nPassword1.isspace() and nPassword2.isspace()): # If password fields are empty, do not update password
                    accountDetails.password = generate_password_hash(nPassword2, method='sha256')
                db.session.commit()

                flash('Account updated successfully!', category='success')
                return redirect(url_for('auth.manageAccounts'))
            
    return render_template("account/editAccount.html", accountDetails=accountDetails, account=current_user)

@auth.route('/deleteAccount/<int:id>') # DELETE ACCOUNT
@login_required
def deleteAccount(id):
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        account = Account.query.filter_by(id=id).first()
        db.session.delete(account)
        db.session.commit()

        flash('Account (ID: ' + str(id) + ') deleted successfully!', category='success')
        return redirect(url_for('auth.manageAccounts'))
    
@auth.route('/searchAccount', methods=['GET', 'POST']) # SEARCH ACCOUNT
@login_required
def searchAccount():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            search = request.form.get('accountSearch')
            filter = request.form.get('filter')

            if filter == "id":
                accounts = Account.query.filter(Account.id.like("%" + search + "%")).order_by(Account.id.asc()).all()
            elif filter == "fullName":
                accounts = Account.query.filter(Account.fullName.like("%" + search + "%")).order_by(Account.id.asc()).all()
            elif filter == "email":
                accounts = Account.query.filter(Account.email.like("%" + search + "%")).order_by(Account.id.asc()).all()
            elif filter == "phoneNo":
                accounts = Account.query.filter(Account.phoneNo.like("%" + search + "%")).order_by(Account.id.asc()).all()
            elif filter == "userType":
                accounts = Account.query.filter(Account.userType.like("%" + search + "%")).order_by(Account.id.asc()).all()
            else:
                accounts = Account.query.order_by(Account.id.asc()).all()

            return render_template("account/manageAccounts.html", accounts=accounts, account=current_user)
        else:
            return redirect(url_for('auth.manageAccounts'))





# PROFILE MANAGEMENT PROFILE MANAGEMENT PROFILE MANAGEMENT PROFILE MANAGEMENT PROFILE MANAGEMENT 
@auth.route('/manageProfiles') # RETRIEVE PROFILES
@login_required
def manageProfiles():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        profiles = Profile.query.join(Account).filter(Profile.account_id == Account.id).order_by(Profile.account_id.asc()).all()

    return render_template("profile/manageProfiles.html", profiles=profiles, account=current_user)

@auth.route('/createProfile', methods=['GET', 'POST']) # CREATE PROFILE
@login_required
def createProfile():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            accountID = request.form.get('accountID')
            profileName = request.form.get('profileName')
            bio = request.form.get('bio')
            if not bio or bio.isspace():
                bio = "No Bio"

            account = Account.query.filter_by(id=accountID).first() # Check for valid Account ID
            profile = Profile.query.filter_by(account_id=accountID).first() # Check if account already has a profile
            if not account:
                flash('Account ID does not exist', category='error')
            elif profile:
                flash('Account ID already has a profile', category='error')
            else:
                new_profile = Profile(profileName=profileName, bio=bio, account=account)
                db.session.add(new_profile)
                db.session.commit()

                flash('Profile successfully created!', category='success')
                return redirect(url_for('auth.manageProfiles'))
            
    return render_template("profile/createProfile.html", account=current_user)

@auth.route('/editProfile/<int:id>', methods=['GET', 'POST']) # UPDATE PROFILE
@login_required
def editProfile(id):
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        profileDetails = Profile.query.join(Account).filter(Profile.account_id == Account.id).filter(Profile.id == id).first()

        if request.method == 'POST':
            profileName = request.form.get('profileName')
            bio = request.form.get('bio')
        
            profileDetails.profileName = profileName
            profileDetails.bio = bio
            db.session.commit()

            flash('Account updated successfully!', category='success')
            return redirect(url_for('auth.manageProfiles'))
            
    return render_template("profile/editProfile.html", profileDetails=profileDetails, account=current_user)

@auth.route('/deleteProfile/<int:id>') # DELETE PROFILE
@login_required
def deleteProfile(id):
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        profile = Profile.query.filter_by(account_id=id).first()
        db.session.delete(profile)
        db.session.commit()

        flash('Profile (belonging to Account ID: ' + str(id) + ') deleted successfully!', category='success')
        return redirect(url_for('auth.manageProfiles'))
    
@auth.route('/searchProfile', methods=['GET', 'POST']) # SEARCH PROFILE
@login_required
def searchProfile():
    if current_user.userType != "userAdmin": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            search = request.form.get('profileSearch')
            filter = request.form.get('filter')

            if filter == "userType":
                profiles = Profile.query.join(Account).filter(Account.userType.like("%" + search + "%")).order_by(Profile.account_id.asc()).all()
            elif filter == "id":
                profiles = Profile.query.filter(Profile.account_id.like("%" + search + "%")).order_by(Profile.account_id.asc()).all()
            elif filter == "fullName":
                profiles = Profile.query.join(Account).filter(Account.fullName.like("%" + search + "%")).order_by(Profile.account_id.asc()).all()
            elif filter == "profileName":
                profiles = Profile.query.filter(Profile.profileName.like("%" + search + "%")).order_by(Profile.account_id.asc()).all()
            else:
                profiles = Profile.query.order_by(Profile.id.asc()).all()

            return render_template("profile/manageProfiles.html", profiles=profiles, account=current_user)
        else:
            return redirect(url_for('auth.manageProfiles'))