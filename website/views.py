from flask import Blueprint, render_template
from flask_login import login_required, current_user

views = Blueprint('views', __name__)

@views.route('/', methods=['GET', 'POST'])
def home():
    return render_template("home.html", user=current_user)


@views.route('/movies', methods=['GET', 'POST'])
def movies():
    return render_template("movies.html", user=current_user)


@views.route('/foodDrinks', methods=['GET', 'POST'])
def foodDrinks():
    return render_template("foodDrinks.html", user=current_user)