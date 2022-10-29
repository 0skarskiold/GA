const category_films = document.getElementById('fold_films');
const category_series = document.getElementById('fold_series');

function openSubFilms() {
    category_films.classList.toggle('subcategory-active');
}

function openSubSeries() {
    category_series.classList.toggle('subcategory-active');
}

category_films.addEventListener('click', openSubFilms);
category_series.addEventListener('click', openSubSeries);

//------------------------------------------------------------------------------

function activateOverlay() {
    document.getElementById('log_overlay').classList.add('overlay-active');
}

function deactivateOverlay() {
    document.getElementById('log_overlay').classList.remove('overlay-active');
}