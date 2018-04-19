@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">

            <div class = "row">

                <div class = "col-sm-12">

                    <h1>Appointments Reports</h1>  
                    <div class="row">
                        <div class="col-xs-12 col-md-8">
                            <h3>This Month</h3>
                            <p>  
                                {{ $report_this_month->toString() }}
                            </p>
                        </div>   
                        <div class="col-xs-12 col-md-8">
                            <h3>Last Month</h3>
                            <p>  
                                {{ $report_last_month->toString() }}
                            </p>
                        </div> 
                        <div class="col-xs-12 col-md-8">
                            <h3>Two Months Ago</h3>
                            <p>  
                                {{ $report_two_months_ago->toString() }}
                            </p>
                        </div> 
                        <div class="col-xs-12 col-md-8">
                            <h3>Three Months Ago</h3>
                            <p>  
                                {{ $report_three_months_ago->toString() }}
                            </p>
                        </div>  
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
