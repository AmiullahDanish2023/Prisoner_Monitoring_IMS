<div class="col-xs-12 col-md-6" style="padding-left: calc(var(--bs-gutter-x) * 0.5);">
    <fieldset>
        <legend>
            Permissions
        </legend>
        <div class="form-group">
            <div class="col-md-12">
                <ul>
                    @php
                        $total_records = count($permission);
                    @endphp
                    @for ($i = 0; $i < $total_records / 2; $i++)
                        <li style="overflow-wrap: anywhere;">
                            <input type="checkbox" value="{{ $permission[$i]->id }}" name="permissions[]" {{$role->hasPermissionTo($permission[$i]->name) == true ? 'checked' : ''}}
                                id="add_role{{ $permission[$i]->id }}">
                            <label for="add_role{{ $permission[$i]->id }}">
                                  @if(Session::get('locale') != 'en')
                                {{ $permission[$i]->name_fa }}
                                @else
                                {{ $permission[$i]->name }}

                                @endif
                            </label>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </fieldset>
</div>
<div class="col-xs-12 col-md-6" style="padding-right: calc(var(--bs-gutter-x) * 0.5);">
    <fieldset>
        <legend>
            Permissions
        </legend>
        <div class="form-group">
            <div class="col-md-12">
                <ul>
                    @for ($i = $i; $i < $total_records; $i++)
                        <li style="overflow-wrap: anywhere;">
                            <input type="checkbox" value="{{ $permission[$i]->id }}" name="permissions[]" {{$role->hasPermissionTo($permission[$i]->name) == true ? 'checked' : ''}}
                                id="add_role{{ $permission[$i]->id }}">
                            <label for="add_role{{ $permission[$i]->id }}">
                            @if(Session::get('locale') != 'en')
                                {{ $permission[$i]->name_fa }}
                                @else
                                {{ $permission[$i]->name }}
                                @endif
                            </label>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </fieldset>
</div>
