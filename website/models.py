from . import db
from flask_login import UserMixin
from sqlalchemy.sql import func

# All database tables + attributes are created here

class Account(db.Model, UserMixin): # Initialization of Database table's attributes
    id = db.Column(db.Integer, primary_key=True)
    userType = db.Column(db.String(12), nullable=False)
    fullName = db.Column(db.String(50), nullable=False)
    email = db.Column(db.String(50), unique=True, nullable=False)
    phoneNo = db.Column(db.Integer, nullable=False)
    password = db.Column(db.String(50), nullable=False)
    profile = db.relationship('Profile', backref='account', uselist=False, cascade="all, delete-orphan")

class Profile(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    account_id = db.Column(db.Integer, db.ForeignKey('account.id'))
    profileName = db.Column(db.String(50), nullable=False)
    bio = db.Column(db.String(150), default='No Bio')
