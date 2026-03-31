<section>

    <form action="{{ route('profile.update') }}" method="post" autocomplete="off">
        @csrf
        @method('patch')
        {{-- 1 --}}

        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label"> اسم المستخدم</label>
                <input type="text" class="form-control" id="inputName" name="name"
                    value="{{ old('name', $user->name) }}">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
            </div>


        </div>

        {{-- 2 --}}
        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label"> البريد الالكتروني</label>
                <input type="text" class="form-control" id="inputName" name="email"
                    value="{{ old('email', $user->email) }}">
                @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>

        </div>


        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary">حفظ </button>
        </div>


    </form>
</section>
