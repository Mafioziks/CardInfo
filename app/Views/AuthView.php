<?php

namespace Views;

class AuthView {
    public static function loginForm() {
        ?>
        <div>
            <form action="/auth/login/" method="post" class="form-horizontal clearfix">
                <div class="form-group">
                    <label class="control-label col-sm-1">Email:</label>
                    <div class="col-sm-2">
                    	<input type="text" name="email" class="form-control">
                	</div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-1">Password:</label>
                    <div class="col-sm-2">
                    	<input type="password" name="password" class="form-control">
                	</div>
                </div>
                <div class="form-group">
                	<button class="btn btn-primary col-sm-3">Log In</button>
            	</div>
            </form>
            <a href="/auth/register/" class="col-sm-3" style="text-align: center;">Register</a>
        </div>
        <?php
    }
    
    public static function registerForm() {
        ?>
        <div>
            <form action="/auth/register/" method="post">
                <div>
                    <label>Name:</label>
                    <input type="text" name="name">
                </div>
                <div>
                    <label>Email:</label>
                    <input type="text" name="email">
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password">
                </div>
                <button>Register</button>
            </form>
        </div>
        <?php
    }
}