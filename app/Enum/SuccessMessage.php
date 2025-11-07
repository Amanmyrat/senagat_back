<?php

namespace App\Enum;

enum SuccessMessage: string
{
    case OTP_SENT = 'otp_sent';
    case OTP_VERIFIED = 'otp_verified';
    case OTP_NOT_MATCH = 'otp_not_match';
    case OTP_EXPIRED = 'otp_expired';
    case USER_INFO_RETRIEVED = 'user_info_retrieved';
    case USER_REGISTERED = 'user_registered';
    case CARDS_RETRIEVED = 'cards_retrieved';
    case PASSWORD_VERIFIED_OTP_SENT = 'password_verified_otp_sent';
    case LOGIN_SUCCESSFUL = 'login_successful';
    case PHONE_EXISTS = 'phone_exists';
    case ORDER_CREATED = 'order_created';
    case CARD_TYPE_LISTED = 'card_type_listed';
    case CERTIFICATE_ORDER_CREATED = 'certificate_order_created';
    case CERTIFICATE_TYPE_LISTED = 'certificate_type_listed';
    case CONTACT_MESSAGE_CREATED = 'contact_message_created';
    case LOAN_ORDER_CREATED = 'loan_order_created';
    case CREDIT_TYPE_LISTED = 'credit_type_listed';
    case EXCHANGE_RATE_LISTED = 'exchange_rate_listed';
    case LOCATION_LISTED = 'location_listed';
    case BRANCH_LOCATIONS_LISTED = 'branch_locations_listed';
    case NEWS_LISTED = 'news_listed';
    case PROFILE_CREATED = 'profile_created';
    case PROFILE_UPDATED = 'profile_updated';

    // #2
    case Deposit_TYPE_LISTED = 'deposit_type_listed';
    case Deposit_TYPE_DETAILS_LISTED = 'deposit_type_details_listed';
}
