<?php

return [

    'static_data' => [
        'max_login_attempts' => env('MAX_LOGIN_ATTEMPTS', 3),
        'login_attempt_timeout_in_minutes' => env('LOGIN_ATTEMPT_TIMEOUT_IN_MINUTES', 30),
        'otp_expiry_time_in_minutes' => env('OTP_EXPIRY_TIME_IN_MINUTES', 2),
    ],

  'siteConfig' => [
    'name' => env('APONJON_FULL_NAME', 'আপনজন'),
    'scam_policy'=>env('scam_policy', 'এই প্ল্যাটফর্মে কোন ফ্রড বা প্রতারণামূলক কাজের অনুমতি নেই। লঙ্ঘনের জন্য আইনগত ব্যবস্থা নেওয়া হবে।'),
    'address' => [
      'head_office' => [
        'address_line' => env('APPONJON_HEAD_OFFICE_ADDRESS', 'ঢাকা বাড্ডা, বাংলাদেশ')
      ],
    ],
    'support_email' => env('SUPPORT_EMAIL', 'support@aponjon.com'),
    'support_phone' => env('SUPPORT_PHONE', '+8801638912320'),

    'social_link' => [
      'facebook' => [
        'label' => 'facebook',
        'url' => env('FACEBOOK_LINK', 'https://web.facebook.com/alirimon12'),
        'icon' => 'fab fa-facebook-f'
      ],
      'linkedin' => [
        'label' => 'linkedin',
        'url' => env('LINKEDIN_LINK', 'https://web.facebook.com/alirimon12'),
        'icon' => 'fab fa-linkedin-in'
      ],
      'instagram' => [
        'label' => 'instagram',
        'url' => env('INSTAGRAM_LINK', 'https://web.facebook.com/alirimon12'),
        'icon' => 'fab fa-instagram'
      ],

    ],

    'supports' => [
      'help_center' => [
        'label' => 'সাহায্য কেন্দ্র',
        'url' => env('HELP_CENTER', 'https://web.facebook.com/alirimon12')
      ],

      'contact' => [
        'label' => 'যোগাযোগ',
        'url' => env('CONTACT', 'https://web.facebook.com/alirimon12')
      ],

      'privacy' => [
        'label' => 'প্রাইভেসি পলিসি',
        'url' => env('PRIVACY_POLICY', 'https://web.facebook.com/alirimon12'),
      ],

      'terms' => [
        'label' => 'টার্মস অ্যান্ড কন্ডিশন',
        'url' => env('TERM_CONDITIONS', 'https://web.facebook.com/alirimon12'),
      ],
    ],

  ],
  'market_place'=>[
    'footer'=>''
  ]

];
