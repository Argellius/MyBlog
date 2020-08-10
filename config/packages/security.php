use App\Entity\Author;

$container->loadFromExtension('security', array(
    'encoders' => array(
        Author::class => array(
            'algorithm' => 'bcrypt',
        ),
    
    ),
    
    'enable_authenticator_manager' => true,

    'providers' => array(
        'our_db_provider' => array(
            'entity' => array(
                'class'    => Author::class,
                'property' => 'Login',
            ),
        ),
    ),
    'firewalls' => array(
        'main' => array(
            'pattern'    => '^/',
            'http_basic' => null,
            'provider'   => 'our_db_provider',
        ),
    ),

    access_control:
        #Prihlaseni pro neprihlasene
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        #Odhlaseni pro prihlasene
        - { path: ^/logout, roles: [ROLE_USER,ROLE_ADMIN]}
    ],    
));