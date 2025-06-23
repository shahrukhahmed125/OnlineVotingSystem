Hello! Voter {{Auth::user()->name}}<br>
<br>
<a href="{{route('voter.vote.create')}}">Vote</a>
<a href="{{route('logout')}}">logout</a>