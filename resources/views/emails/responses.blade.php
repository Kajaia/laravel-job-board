<div>
    Vacancy title: <strong>{{ $vacancy->title }}</strong>
    <br>
    Sender: <strong>{{ $user }}</strong>
    <br>
    Number of responses: <strong>{{ $vacancy->responses->count() }}</strong>
    <br>
    Date: <strong>{{ $date }}</strong>
</div>