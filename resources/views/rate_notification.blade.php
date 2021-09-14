Poštovani/a,
<p>
	Dodat je komentar za {{$objectType}}: <b>{{$objectName}}</b>
</p>
<p>
	@if ( app('auth')->user()->isTrusted() )
		Korisnik koji je postavio komentar ima status korisnika od poverenja i komentar će automatski biti odobren
	@else
		Korisnik koji je postavio komentar nema status korisnika od poverenja, potrebno je da administrator odobri komentar
	@endif
</p>