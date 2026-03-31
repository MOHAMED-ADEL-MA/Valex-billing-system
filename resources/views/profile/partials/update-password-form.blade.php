<section>

    <form action="{{ route('password.update') }}" method="post" autocomplete="off">
        @csrf
        @method('put')
        {{-- 1 --}}

        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label">كلمه المرور الحاليه</label>
                <input type="password" class="form-control" id="inputName" name="current_password"
                    value="{{ old('current_password') }}">
                @if ($errors->updatePassword->has('current_password'))
                    <small class="text-danger">{{ $errors->updatePassword->first('current_password') }}</small>
                @endif
            </div>


        </div>

        {{-- 2 --}}
        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label">كلمه المرور الجديدة</label>
                <input type="password" class="form-control" id="inputName" name="password">
                @if ($errors->updatePassword->has('password'))
                    <small class="text-danger">{{ $errors->updatePassword->first('password') }}</small>
                @endif
            </div>

        </div>
        {{-- 3 --}}
        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label">تاكيد كلمه المرور</label>
                <input type="password" class="form-control" id="inputName" name="password_confirmation">
                @if ($errors->updatePassword->has('password_confirmation'))
                    <small class="text-danger">{{ $errors->updatePassword->first('password_confirmation') }}</small>
                @endif
            </div>

        </div>


        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary">حفظ </button>
        </div>


    </form>
</section>
