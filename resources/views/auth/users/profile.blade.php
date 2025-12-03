@extends('layouts.master')
{{-- magosh --}}
@section('content')
    <div class="row mt-4">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center mb-4">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset($user->photo == null ? 'assets/media/avatars/blank.png' : $user->photo) }}"
                            style="width: 120px; border-radius: 60px;" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <h5 class="text-muted text-center">{{ $user->email }}</h5>

                    <h5 class="text-muted text-center">{{ $dep->name_dr }}</h5>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="py-6 px-6">
                    <h4 class="d-inline">{{ __('translate.user information') }}</h4>
                    <button type="button" class="btn btn-sm btn-primary"
                        @if (Session::get('locale') == 'en') style="float: right" @endif style="float: left;"
                        data-bs-toggle="modal"
                        data-bs-target="#password_modal">{{ __('translate.change password') }}</button>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        {{-- <div class="modal fade" id="updateModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">@lang('auth/profile.Your_Complete_Information')</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.profile') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label for="">@lang('auth/profile.Select_Your_Photo')</label>
                                    <input type="file" accept="image/*" class="form-control-file" name="photo">
                                </div>
                                <div class="col-xs-12 col-md-12">
                                    <label for="">@lang('auth/profile.Information_About_You')</label>
                                    <textarea class="form-control" name="information" cols="30" rows="8">{{ $user->information }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-dark" data-dismiss="modal" type="button">@lang('auth/profile.Close')</button>
                                <button class="btn btn-primary" type="submit">@lang('auth/profile.Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="password_modal" tabindex="-1" role="dialog" class="modal fade">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">{{ __('translate.change password') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="passwordForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label for="old_password">{{ __('translate.previous password') }}</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password">
                                    <span id="old_password-error" class="error"></span>

                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="password">{{ __('translate.new password') }}</label>
                                    <input type="password" class="form-control"
                                        id="password" name="password">
                                        <span id="password-error" class="error"></span>

                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="password_confirmation">{{ __('translate.confirm password') }}</label>
                                    <input type="password"
                                        class="form-control"
                                        id="password_confirmation" name="password_confirmation">
                                        <span id="password_confirmation-error" class="error"></span>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal"
                                type="button">{{ __('translate.close') }}</button>
                            <button class="btn btn-primary" type="submit">{{ __('translate.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var valid = $('#passwordForm').validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {
                    old_password: {
                        required: '<span class="text-danger" style="font-size:13px; font-weight:bold">درج رمز گذشته ضروری میباشد</span>',
                    },
                    password: {
                        required: '<span class="text-danger" style="font-size:13px; font-weight:bold">درج رمز جدید ضروری میباشد</span>',
                        minlength: '<span class="text-danger" style="font-size:13px; font-weight:bold">رمز جدید باید از ۶ حرف کم نباشد</span>',
                    },
                }
            });
        });

        $(document).on('submit', '#passwordForm', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('change-user-password') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response.status === true) {
                        $('#passwordForm')[0].reset();
                        $('#password_modal').modal('hide');
                        Swal.fire({
                            title: 'معلومات ذخیره شد',
                            text: response.data,
                            icon: 'success',
                            showConfirmButton: true,
                            allowOutsideClick: false
                        });
                    } else {
                            $.each(response.data, function(prefix, val) {
                                var error = '<label id="' + prefix +
                                    '-error" class="error" for="' + prefix + '">' + val[0] +
                                    '</label>';
                                $("input[name=" + prefix + "]").after(error);
                                $("select[name=" + prefix + "]").after(error);
                            });
                        }
                },
                error: function() {
                    Swal.fire({
                        title: 'معلومات ذخیره نشد',
                        text: response.data,
                        icon: 'error'
                    })
                }
            });
        });
    </script>
@endsection
