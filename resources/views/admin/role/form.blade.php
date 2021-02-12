@extends('layouts.app')
@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
             ($data->role_id)?'Edit':'Create'
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="form" method="post" action="{{url($url)}}/save">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Code</label>
                            <div class="col-4">
                                <input class="form-control" name="role_code" type="text" PLACEHOLDER="Role Code"
                                       value="{{$data->role_code}}"
                                       required maxlength="50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Role Name</label>
                            <div class="col-4">
                                <input class="form-control" name="role_name" type="text" PLACEHOLDER="Role Name"
                                       value="{{$data->role_name}}"
                                       required maxlength="50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Status</label>
                            <div class="col-4">
                                <select name="is_active" id="" class="form-control">
                                    <option value="t" {{($data->is_active==true)?'selected':''}}>Active</option>
                                    <option value="f" {{($data->is_active==false)?'selected':''}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Verificator</label>
                            <div class="col-4">
                                <select name="is_verificator" id="" class="form-control">
                                    <option value="t" {{($data->is_verificator==true)?'selected':''}}>Yes</option>
                                    <option value="f" {{($data->is_verificator==false)?'selected':''}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Loan Type</label>
                            <div class="col-4">
                                <select name="loan_type" id="" class="form-control">
                                    <option value="">choose</option>
                                    <option value="1" {{($data->loan_type==1)?'selected':''}}>Money</option>
                                    <option value="2" {{($data->loan_type==2)?'selected':''}}>Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Role Type</label>
                            <div class="col-4">
                                <select name="role_type" id="" class="form-control">
                                    <option value="1" {{($data->role_type==1)?'selected':''}}>Internal</option>
                                    <option value="2" {{($data->role_type==2)?'selected':''}}>External</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Upgrade
                                Status</label>
                            <div class="col-4">
                                <select name="upgrade_status[]" id="" class="form-control select2" multiple>
                                    @foreach(\App\Models\UpgradeStatus::all() as $i)
                                        <option value="{{$i->upgrade_status_id}}" {{(in_array($i->upgrade_status_id,$data->upgradeStatuses->pluck('upgrade_status_id')->toArray()))?'selected':''}}>{{$i->upgrade_status_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right ">Menu</label>
                            <div class="col-4">
                                @php
                                    $menu_id_list = ($data->roleMenus)? collect($data->roleMenus)->where('is_active', true)->pluck('menu_id')->toArray():[];
                                    $menu = \App\Models\Menu::where('parent_id',0)->orderBy('order_num')->get()
                                @endphp

                                <ul class="checktree">
                                    @foreach($menu as $i)
                                        <li>
                                            <input id="{{$i->label}}" type="checkbox" name="menu_id[]"
                                                   {{(in_array($i->menu_id, $menu_id_list))?'checked':''}}
                                                   value="{{$i->menu_id}}"><label
                                                    for="{{$i->label}}">{{$i->label}}</label>
                                            <ul>
                                                @foreach(collect($i->childMenus)->sortBy('order_num') as $i2)
                                                    <li><input
                                                                id="{{$i2->label}}" type="checkbox" name="menu_id[]"
                                                                {{(in_array($i2->menu_id, $menu_id_list))?'checked':''}}
                                                                value="{{$i2->menu_id}}"><label
                                                                {!!  ($i2->is_active!=1)?'class="text-danger"':''!!}
                                                                for="{{$i2->label}}">{{$i2->label}}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label text-right "></label>
                            <div class="col-4">
                                <input type="hidden" value="{{$data->role_uuid}}" name="role_uuid">
                                <input type="submit" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
    <script type="text/javascript" src="/assets/node_modules/checkbox-tree/js/checktree.js"></script>
    <script>
        $(document).ready(function () {
            // $("ul.checktree").checktree();

            url = '{{url($url)}}'
            $(".select2").select2();
        });
    </script>
@endsection