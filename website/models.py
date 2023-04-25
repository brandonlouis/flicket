from . import db
from flask_login import UserMixin
from sqlalchemy.sql import func, text

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

class SpokenLanguage(db.Model):
    __tablename__ = 'spokenLanguage'
    id = db.Column(db.Integer, primary_key=True)
    langName = db.Column(db.String(50), nullable=False)
    movies = db.relationship('Movie',backref='spokenLanguage', lazy=True, cascade="all, delete-orphan")

genres = db.Table('genres',
    db.Column('genre_id', db.Integer, db.ForeignKey('genre.id'), primary_key=True),
    db.Column('movie_id', db.Integer, db.ForeignKey('movie.id'), primary_key=True)
)
class Movie(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(100), nullable=False)
    sypnosis = db.Column(db.String(150), nullable=False)
    totalScore = db.Column(db.Float, server_default=text("0"))
    totalRatingsGiven = db.Column(db.Integer, server_default=text("0"))
    runtimeMin = db.Column(db.Integer,nullable=False)
    trailerLink = db.Column(db.String(300), nullable=False)
    startDate = db.Column(db.DateTime, nullable=False)
    endDate = db.Column(db.DateTime, nullable=False)
    spokenLanguage_id = db.Column(db.Integer, db.ForeignKey('spokenLanguage.id'), nullable=False)
    genres = db.relationship('Genre', secondary=genres, lazy='subquery', backref=db.backref('genres',lazy=True))
class Genre(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    genreName = db.Column(db.String(50), nullable=False)


class CinemaLocation(db.Model):
    __tablename__ = 'cinemaLocation'
    id = db.Column(db.Integer, primary_key=True)
    locationName = db.Column(db.String(50), nullable=False)
    screenings = db.relationship('Screening', backref='cinemaLocation', lazy=True,cascade="all, delete-orphan")

class Hall(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    hallName = db.Column(db.String(50), nullable=False)
    screenings = db.relationship('Screening', backref='hall', lazy=True,cascade="all, delete-orphan")

class Timeslot(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    startTime = db.Column(db.DateTime, nullable=False)
    endTime = db.Column(db.DateTime, nullable=False)
    screenings = db.relationship('Screening', backref='timeslot', lazy=True, cascade="all, delete-orphan")
class Screening(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    cinemaLocation_id = db.Column(db.Integer, db.ForeignKey('cinemaLocation.id'),
        nullable=False)
    hall_id = db.Column(db.Integer, db.ForeignKey('hall.id'),nullable=False)
    timeslot_id = db.Column(db.Integer, db.ForeignKey('timeslot.id'),nullable=False)



