from website import db, create_app
from website.models import *
from werkzeug.security import generate_password_hash


def insert_new_genres():
    new_genres = [
        Genre(genreName="None"),
        Genre(genreName='Action'),
        Genre(genreName='Romance'),
        Genre(genreName='Sci-Fi'),
        Genre(genreName='Fantasy'),
        Genre(genreName='Thriller')
    ]

    for new_genre in new_genres:
        db.session.add(new_genre)
    db.session.commit()


def insert_new_spokenLanguages():
    new_spokenLanguages = [
        SpokenLanguage(langName='English'),
        SpokenLanguage(langName='Mandarin'),
        SpokenLanguage(langName='Malay'),
        SpokenLanguage(langName='Tamil'),
        SpokenLanguage(langName='Japanese')
    ]

    for new_spokenLang in new_spokenLanguages:
        db.session.add(new_spokenLang)
    db.session.commit()


def insert_new_accounts_profiles():
    new_accounts = [
        Account(userType="userAdmin", fullName="Adam Tan", email="adamtan@flicket.com",
                phoneNo="91234567", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="userAdmin", fullName="Alicia Mark", email="aliciam@flicket.com",
                phoneNo="81234567", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="cinemaManager", fullName="Bob Ng", email="bobng@flicket.com",
                phoneNo="98765432", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="cinemaManager", fullName="Bala Gonzales", email="balag@flicket.com",
                phoneNo="88765432", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="cinemaOwner", fullName="Caroline Jacobs", email="carolinej@flicket.com",
                phoneNo="98761234", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="cinemaOwner", fullName="Calvin Klein", email="calvink@flicket.com",
                phoneNo="88761234", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="customer", fullName="Zion Faries", email="zionf@gmail.com",
                phoneNo="91238765", password=generate_password_hash("123qwe", method='sha256')),
        Account(userType="customer", fullName="Zac Efron", email="zacE@hotmail.com",
                phoneNo="81238765", password=generate_password_hash("123qwe", method='sha256'))
    ]
    new_profiles = [
        Profile(profileName="AdamTanzaniteFR", account=new_accounts[0]),
        Profile(profileName="AMark435099", account=new_accounts[1]),
        Profile(profileName="BobTheBuilder", account=new_accounts[2]),
        Profile(profileName="BalGon87", account=new_accounts[3]),
        Profile(profileName="CYakob", account=new_accounts[4]),
        Profile(profileName="Kleinman942", account=new_accounts[5]),
        Profile(profileName="ZionF4U", account=new_accounts[6]),
        Profile(profileName="HighSchMusical2", account=new_accounts[7])
    ]
    for new_account in new_accounts:
        db.session.add(new_account)
    for new_profile in new_profiles:
        db.session.add(new_profile)
    db.session.commit()


if __name__ == "__main__":
    app = create_app()
    with app.app_context():
        insert_new_genres()
        insert_new_spokenLanguages()
        insert_new_accounts_profiles()
