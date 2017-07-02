<?php

namespace Views;

class AuthView {
    public static function loginForm() {
        ?>
        <div>
            <form action="/auth/login/" method="post">
                <div>
                    <label>Email:</label>
                    <input type="text" name="email">
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password">
                </div>
                <button>Log In</button>
            </form>
            <a href="/auth/register/">Register</a>
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