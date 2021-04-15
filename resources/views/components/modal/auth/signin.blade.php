<form id="signin" action="/signin" method="post">
    @csrf
    @method('post')
    <div class="input-group">
        <label for="signin_data">
            <span>Data:</span>
        </label>
        <input class="form-input" type="text" name="signin_data" id="signin_data">
        @if ($errors->has('signin_data'))
            <span class="error support support-box support-signin_data">{{ $errors->first('signin_data') }}</span>
        @else
            <span class="error support support-box support-signin_data"></span>
        @endif
    </div>
    <div class="input-group">
        <label for="signin_password">
            <span>Password:</span>
        </label>
        <input class="form-input" type="password" name="signin_password" id="signin_password">
        @if ($errors->has('signin_password'))
            <span class="error support support-box support-signin_password">{{ $errors->first('signin_password') }}</span>
        @else
            <span class="error support support-box support-signin_password"></span>
        @endif
    </div>
    <div class="submit-group">
        <label><input type="checkbox" name="signin_remember">Remember</label>
        <button class="signin form-submit" type="submit">
            <span>Submit</span>
        </button>
    </div>
</form>