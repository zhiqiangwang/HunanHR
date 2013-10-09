<?php
namespace HR\Bundle\UserBundle;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
final class UserEvents
{
    const PROFILE_EDIT_COMPLETED = 'user.profile.edit.completed';

    const REGISTRATION_COMPLETED = 'user.registration.completed';

    const CHANGE_PASSWORD_COMPLETED = 'user.change_password.edit.completed';

    const RESETTING_RESET_COMPLETED = 'user.resetting.reset.completed';

    const SECURITY_IMPLICIT_LOGIN = 'user.security.implicit_login';
}