@extends('customer.layout')

@section('content')
    <h2>Instructor Request Details</h2>

    <pre>{{ print_r($instructorRequest, true) }}</pre>
@endsection
