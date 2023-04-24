from flask import Blueprint, render_template, flash, redirect, url_for
from flask_login import login_required, current_user

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
        return render_template("manageMovies.html", user=current_user)
