<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">{{__('messages.contactInfo')}}</h6>
        <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
            {{__('messages.noteNotice')[1]}}</small>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <label class="form-label">{{__('messages.cities')}}</label>
                <select class="form-select init-select2 locations provinces" name="province_id" data-target="districts">
                    <option disabled selected>[{{__('messages.cities')}}]</option>
                    @empty(!$provinces)

                    @foreach ($provinces as $province )
                    @php
                    $selected = $province->code == old('province_id', isset($user->province_id) ?
                    $user->province_id : '') ? 'selected' : ''
                    @endphp
                    <option {{$selected}} value="{{$province->code}}">{{$province->name}}</option>

                    @endforeach
                    @endempty
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('messages.districts')}}</label>
                <select class="form-select init-select2 locations districts" name="district_id" data-target="wards">
                    <option selected disabled>[{{__('messages.districts')}}]</option>

                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('messages.wards')}}</label>
                <select class="form-select init-select2 wards" name="ward_id">
                    <option selected>[{{__('messages.wards')}}]</option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{__('messages.phone')}}</label>
                <input type="tel" name="phone" value="{{old('phone', $user->phone ?? '')}}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{__('messages.address')}}</label>
                <input type="text" name="address" value="{{old('address', $user->address ?? '')}}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{__('messages.notes')}}</label>
                <input type="text" name="description" value="{{old('description', $user->description ?? '')}}"
                    class="form-control">
            </div>

        </div>
    </div>
</div>