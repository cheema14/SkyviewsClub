@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.sportsBilling.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sports-billings.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.id') }}
                        </th>
                        <td>
                            {{ $sportsBilling->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name') }}
                        </th>
                        <td>
                            {{ $sportsBilling->member_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name') }}
                        </th>
                        <td>
                            {{ $sportsBilling->non_member_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date') }}
                        </th>
                        <td>
                            {{ $sportsBilling->bill_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number') }}
                        </th>
                        <td>
                            {{ $sportsBilling->bill_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks') }}
                        </th>
                        <td>
                            {{ $sportsBilling->remarks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.ref_club') }}
                        </th>
                        <td>
                            {{ $sportsBilling->ref_club }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.club_id_ref') }}
                        </th>
                        <td>
                            {{ $sportsBilling->club_id_ref }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.tee_off') }}
                        </th>
                        <td>
                            {{ $sportsBilling->tee_off }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.holes') }}
                        </th>
                        <td>
                            {{ $sportsBilling->holes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.caddy') }}
                        </th>
                        <td>
                            {{ $sportsBilling->caddy }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_mbr') }}
                        </th>
                        <td>
                            {{ $sportsBilling->temp_mbr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_caddy') }}
                        </th>
                        <td>
                            {{ $sportsBilling->temp_caddy }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.pay_mode') }}
                        </th>
                        <td>
                            {{ App\Models\SportsBilling::PAY_MODE_SELECT[$sportsBilling->pay_mode] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.gross_total') }}
                        </th>
                        <td>
                            {{ $sportsBilling->gross_total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.total_payable') }}
                        </th>
                        <td>
                            {{ $sportsBilling->total_payable }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.bank_charges') }}
                        </th>
                        @if ($sportsBilling->pay_mode == 'card')
                            <td>
                                {{ $sportsBilling->bank_charges }}
                            </td>    
                        @else
                            <td>
                                N/A
                            </td>
                           
                        @endif
                        
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.net_pay') }}
                        </th>
                        <td>
                            {{ $sportsBilling->net_pay }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sports-billings.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection