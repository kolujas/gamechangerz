<form id="login" action="/login" method="post" class="grid">
    @csrf
    @method('post')
    <div class="input-group grid">
        <label for="login_data">
            <span>Data:</span>
        </label>
        <input class="form-input" type="text" name="login_data" id="login_data" placeholder="Email or username" value={{ old('login_data', '') }}>
        @if ($errors->has('login_data'))
            <span class="error support support-box support-login_data">{{ $errors->first('login_data') }}</span>
        @else
            <span class="error support support-box support-login_data"></span>
        @endif
    </div>
    <div class="input-group grid">
        <label for="login_password">
            <span>Password:</span>
        </label>
        <input class="form-input" type="password" name="login_password" id="login_password" placeholder="Password">
        @if ($errors->has('login_password'))
            <span class="error support support-box support-login_password">{{ $errors->first('login_password') }}</span>
        @else
            <span class="error support support-box support-login_password"></span>
        @endif
    </div>
    <div class="submit-group">
        <label><input type="checkbox" name="login_remember">Remember</label>
        <button class="login form-submit" type="submit">
            <span>Submit</span>
        </button>
    </div>
</form>