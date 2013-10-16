<?php
namespace HR\UserBundle;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
final class UserEvents
{
    const PROFILE_EDIT_COMPLETED = 'user.profile_edit.completed';

    const EMAIL_CHANGE_COMPLETED = 'user.email_change.completed';

    const REGISTRATION_SUCCESS = 'user.registration.success';

    const REGISTRATION_COMPLETED = 'user.registration.completed';

    const REGISTRATION_CONFIRMED = 'user.registration.confirmed';

    const CHANGE_PASSWORD_COMPLETED = 'user.change_password.edit.completed';

    const RESETTING_RESET_COMPLETED = 'user.resetting.reset.completed';

    const SECURITY_IMPLICIT_LOGIN = 'user.security.implicit_login';
}