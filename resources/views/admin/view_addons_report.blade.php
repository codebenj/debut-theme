@extends('layouts.admin')
<style type="text/css">
.section-report .panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
    box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
}
.section-report .panel-default>.panel-heading {
    color: #333;
    position: relative;
    background-color: #f5f5f5;
    border-color: #ddd;
}
.section-report .panel-heading h6 {
    margin-bottom: 0;
}
.section-report .accordion-button {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    padding: 12px 15px;
    font-size: 1.3rem;
    color: #212529;
    text-align: left;
    border: 0;
    text-decoration: none;
    border-bottom: 1px solid #ddd;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}
.section-report .panel-body {
    padding: 15px 15px 0 15px;
}
.section-report .panel-color .card-body {
    min-height: 295px !important;
}
.section-report .card .card-title {
    font-size: 17px;
}
.section-report .card .card-text {
    font-size: 15px;
}
.section-report .panel-addons .card .card-body {
    font-size: 15px;
}
.section-report .panel-addons .card .card-body .text-sm {
    font-size: 13px;
}
.btn-csv {
    top: 10px;
    right: 10px;
    position: absolute;
}
</style>

@section('content')
<div class="section-report">
    <div class="row">
        <div class="offset-7 col-md-5 text-right">
            <h6>Total Paid Stores: <span class="badge badge-primary">{{$report->stores_update_info['total_paid_stores']}}</span></h6>
            <h6>Total Updated Stores: <span class="badge badge-primary">{{$report->stores_update_info['updated_count']}}</span></h6>
            <h6>Generate Report Date (UTC Time): {{ date('Y-m-d H:i:s', strtotime($report->report_generate_date )) }}</h6>
        </div>
    </div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default panel-addons">
            <div class="panel-heading" role="tab" id="headingOne">
                <h6>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="accordion-button">All Active AddOns:</a>
                    <a class="btn btn-secondary btn-sm btn-csv" href="{{ route('admin.export', [$report->id, 'all_active_addons']) }}">Export Excel <i class="fa fa-download"></i></a>
                </h6>

            </div>
            <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="row">
                    @foreach ($report->all_active_addons as $addons_data)
                    <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <span class="text-uppercase">{{$addons_data->addon_name}}:</span>
                            <span class="badge badge-secondary text-sm">{{$addons_data->active_install_count}}</span>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
        </div>

        <div class="panel panel-default panel-plan-addons">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h6>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="accordion-button">Plan Wise Active AddOns:</a>
                    <a class="btn btn-secondary btn-sm btn-csv" href="{{ route('admin.export', [$report->id, 'plan_wise_active_addons']) }}">Export Excel <i class="fa fa-download"></i></a>
                </h6>
            </div>
            <div id="collapseTwo" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <div class="row">
                    @foreach ($report->plan_wise_active_addons as $plan_wiseaddons_data)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <span class="badge badge-secondary text-uppercase font-italic">{{ $plan_wiseaddons_data->plan_name }}</span>
                            </div>
                          <div class="card-body">
                            <div class="card-text">
                                <ul style="list-style: circle;">
                                    @foreach ($plan_wiseaddons_data->addons_info as $addons_info)
                                        <li>{{ $addons_info->addon_name }}: {{ $addons_info->active_install_count }}</li>
                                    @endforeach
                                </ul>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
        </div>

        <div class="panel panel-default panel-color">
            <div class="panel-heading" role="tab" id="headingThree">
                <h6>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="accordion-button">Top Used Colors:</a>
                    <a class="btn btn-secondary btn-sm btn-csv" href="{{ route('admin.export', [$report->id, 'top_used_colors']) }}">Export Excel <i class="fa fa-download"></i></a>
                </h6>
            </div>
            <div id="collapseThree" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <div class="row">
                    @foreach ($report->top_used_colors as $color_data)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="badge badge-secondary text-uppercase font-italic">{{ $color_data->color_name }}</span>
                            </div>
                          <div class="card-body">
                            <div class="card-text">
                                <ul style="list-style: circle;">
                                    @foreach ($color_data->color_array as $key => $val)
                                        <li>{{$key}}: {{$val}}</li>
                                    @endforeach
                                </ul>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection