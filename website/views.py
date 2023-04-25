from flask import Blueprint, render_template, flash, redirect, url_for, request
from flask_login import login_required, current_user
from .models import Genre, SpokenLanguage, Movie
from . import db
from datetime import datetime
from math import floor

views = Blueprint('views', __name__)

@views.route('/', methods=['GET', 'POST'])
def home():
    return render_template("home.html", account=current_user)

@views.route('/movies', methods=['GET', 'POST'])
def movies():
    return render_template("movies.html", account=current_user)

@views.route('/foodDrinks', methods=['GET', 'POST'])
def foodDrinks():
    return render_template("foodDrinks.html", user=current_user)

@views.route('/manageMovies', methods=['GET', 'POST'])
@login_required
def manageMovies():
    if current_user.userType != "cinemaOwner":
        flash('You are not authorized to enter the manage movies page', category='error')
        return redirect(url_for("views.home"))
    else:
        movies = Movie.query.order_by(Movie.id).all()
        return render_template("manageMovies.html", account=current_user, movies=movies)
    

@views.route('/searchMovie', methods=['GET', 'POST']) # SEARCH ACCOUNT
@login_required
def searchMovie():
    if current_user.userType != "cinemaOwner": # Prevent invalid logged in users from accessing
        return redirect(url_for('views.home'))
    else:
        if request.method == 'POST':
            search = request.form.get('movieSearch')
            filter = request.form.get('filter')

            if filter == "id":
                movies = Movie.query.filter(Movie.id.like("%" + search + "%")).order_by(Movie.id.asc()).all()
            elif filter == "title":
                movies = Movie.query.filter(Movie.title.like("%" + search + "%")).order_by(Movie.id.asc()).all()
            else:
                movies = Movie.query.order_by(Movie.id.asc()).all()

            return render_template("manageMovies.html", movies=movies, account=current_user)
        else:
            return redirect(url_for('views.manageMovies'))
    
@views.route('/createMovie', methods=['GET', 'POST'])
@login_required
def createMovie():
    if current_user.userType != "cinemaOwner":
        flash('You are not authorized to enter the create movies page', category='error')
        return redirect(url_for("views.home"))
    else:
        if request.method == 'POST':
            title = request.form.get('title')
            spokenLanguage = request.form.get('spokenLanguage')
            genre1 = request.form.get('genre1')
            genre2 = request.form.get('genre2')
            runtimeHour = request.form.get('runtimeHour')
            runtimeMin = request.form.get('runtimeMin')
            startDate = request.form.get('startDate')
            endDate = request.form.get('endDate')
            sypnosis = request.form.get('sypnosis')
            trailerLink = request.form.get('trailerLink')

            startDate = datetime.strptime(startDate,'%Y-%m-%d')
            endDate = datetime.strptime(endDate,'%Y-%m-%d')
            
            try:
                runtimeHour = int(runtimeHour)
            except ValueError:
                flash('Runtime hours should be an integer', category='error')

            try:
                runtimeMin = int(runtimeMin)
            except ValueError:
                flash('Runtime minutes should be an integer', category='error')

            if genre1 == genre2:
                flash('Genres should not be the same', category='error')
            elif genre1 == "None" and genre2 == "None":
                flash('Both genres should not be None', category='error')
            elif runtimeMin >= 60 or runtimeMin < 0:
                flash('Runtime minutes should be between 0 and 60', category='error')
            elif runtimeHour == 0 and runtimeMin == 0:
                flash('Runtime minutes and hours should not add up to be 0', category='error')
            elif startDate > endDate:
                flash('The start date should be before the end date', category='error')

            else:
                runtimeInMin = runtimeHour * 60 + runtimeMin
                new_spokenLanguage = SpokenLanguage.query.filter_by(langName=spokenLanguage).first()
                new_genre1 = Genre.query.filter_by(genreName=genre1).first()
                new_genre2 = Genre.query.filter_by(genreName=genre2).first()
                new_movie = Movie(title=title, sypnosis=sypnosis, runtimeMin=runtimeInMin,trailerLink=trailerLink,
                                  startDate=startDate,endDate=endDate,spokenLanguage=new_spokenLanguage)
                new_movie.genres.append(new_genre1)
                new_movie.genres.append(new_genre2)

                db.session.add(new_movie)
                db.session.commit()
                
                flash('Movie successfully created!', category='success')
                return redirect(url_for('views.manageMovies'))
        genres = Genre.query.order_by(Genre.genreName).all()
        spokenLanguages = SpokenLanguage.query.order_by(SpokenLanguage.langName).all()
        return render_template("createMovie.html", account=current_user, genres=genres,
                               spokenLanguages=spokenLanguages)

@views.route('/viewMovie/<int:id>', methods=['GET', 'POST'])
@login_required
def viewMovie(id):
    if current_user.userType != "cinemaOwner":
        flash('You are not authorized to enter the view movies page', category='error')
        return redirect(url_for("views.home"))
    else:
        movie_details = Movie.query.filter_by(id=id).first()
        startDate_str = movie_details.startDate.strftime("%Y-%m-%d")
        endDate_str = movie_details.endDate.strftime("%Y-%m-%d")
        runtimeHour = floor(movie_details.runtimeMin / 60)
        runtimeMin = movie_details.runtimeMin % 60
        
        genres = movie_details.genres
        genreStr = ""
        for i in range(len(genres)):
            if genres[i].genreName == "None":
                pass
            else:
                if i == (len(genres) - 1):
                    genreStr += genres[i].genreName
                else:
                    genreStr += genres[i].genreName + ", "
            
        return render_template("viewMovie.html", movie_details=movie_details, account=current_user,
                               startDate_str=startDate_str,endDate_str=endDate_str, 
                               runtimeHour=runtimeHour, runtimeMin=runtimeMin, genreStr=genreStr)

@views.route('/editMovie/<int:id>', methods=['GET', 'POST'])
@login_required
def editMovie(id):
    if current_user.userType != "cinemaOwner":
        flash('You are not authorized to enter the edit movies page', category='error')
        return redirect(url_for("views.home"))
    else:
        movie_details = Movie.query.filter_by(id=id).first()
        startDate_str = movie_details.startDate.strftime("%Y-%m-%d")
        endDate_str = movie_details.endDate.strftime("%Y-%m-%d")
        runtimeHour = floor(movie_details.runtimeMin / 60)
        runtimeMin = movie_details.runtimeMin % 60

        if request.method == 'POST':
            title = request.form.get('title')
            spokenLanguage = request.form.get('spokenLanguage')
            genre1 = request.form.get('genre1')
            genre2 = request.form.get('genre2')
            runtimeHour = request.form.get('runtimeHour')
            runtimeMin = request.form.get('runtimeMin')
            startDate = request.form.get('startDate')
            endDate = request.form.get('endDate')
            sypnosis = request.form.get('sypnosis')
            trailerLink = request.form.get('trailerLink')

            startDate = datetime.strptime(startDate,'%Y-%m-%d')
            endDate = datetime.strptime(endDate,'%Y-%m-%d')
            
            try:
                runtimeHour = int(runtimeHour)
            except ValueError:
                flash('Runtime hours should be an integer', category='error')

            try:
                runtimeMin = int(runtimeMin)
            except ValueError:
                flash('Runtime minutes should be an integer', category='error')

            if genre1 == genre2:
                flash('Genres should not be the same', category='error')
            elif genre1 == "None" and genre2 == "None":
                flash('Both genres should not be None', category='error')
            elif runtimeMin >= 60 or runtimeMin < 0:
                flash('Runtime minutes should be between 0 and 60', category='error')
            elif runtimeHour == 0 and runtimeMin == 0:
                flash('Runtime minutes and hours should not add up to be 0', category='error')
            elif startDate > endDate:
                flash('The start date should be before the end date', category='error')

            else:
                runtimeInMin = runtimeHour * 60 + runtimeMin
                new_spokenLanguage = SpokenLanguage.query.filter_by(langName=spokenLanguage).first()
                new_genre1 = Genre.query.filter_by(genreName=genre1).first()
                new_genre2 = Genre.query.filter_by(genreName=genre2).first()
                
                movie_details.title = title
                movie_details.spokenLanguage = new_spokenLanguage
                movie_details.runtimeMin = runtimeInMin
                movie_details.startDate = startDate
                movie_details.endDate = endDate
                movie_details.sypnosis = sypnosis
                movie_details.sypnosis = sypnosis
                movie_details.trailerLink = trailerLink

                movie_details.genres.clear()
                movie_details.genres.append(new_genre1)
                movie_details.genres.append(new_genre2)

                db.session.commit()
                
                flash('Movie updated successfully!', category='success')
                return redirect(url_for('views.manageMovies'))
        genres = Genre.query.order_by(Genre.genreName).all()
        spokenlanguages = SpokenLanguage.query.order_by(SpokenLanguage.langName).all()
        return render_template("editMovie.html", movie_details=movie_details, account=current_user,
                               genres=genres,spokenLanguages=spokenlanguages, startDate_str=startDate_str,
                               endDate_str=endDate_str, runtimeHour=runtimeHour, runtimeMin=runtimeMin)
    
@views.route('/deleteMovie/<int:id>') 
@login_required
def deleteMovie(id):
    if current_user.userType != "cinemaOwner": 
        flash('You are not authorized to enter the delete movies page', category='error')
        return redirect(url_for('views.home'))
    else:
        chosen_movie = Movie.query.filter_by(id=id).first()
        db.session.delete(chosen_movie)
        db.session.commit()

        flash('Movie (ID: ' + str(id) + ') deleted successfully!', category='success')
        return redirect(url_for('views.manageMovies'))
