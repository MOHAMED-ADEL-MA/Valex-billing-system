<section class="space-y-6">

    <form action="{{ route('profile.destroy') }}" method="post" autocomplete="off">
        @csrf
        @method('delete')
        {{-- 1 --}}

        <div class="row">
            <div class="col">
                <p class="text-danger">عند حذف الحساب لا يمكنك استرجاعه مره اخري كما انه سيتم حذف اي بيانات مرتبطه بهذا
                    الحساب</p>
            </div>


        </div>

        {{-- 2 --}}
        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label">كلمه المرور </label>
                <input type="password" class="form-control" id="inputName" name="password">
                @if ($errors->userDeletion->has('password'))
                    <small class="text-danger">{{ $errors->userDeletion->first('password') }}</small>
                @endif
            </div>

        </div>



        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-danger">حذف </button>
        </div>


    </form>
</section>
