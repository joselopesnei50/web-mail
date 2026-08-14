<?php

return [
    'default' => env('IMAP_DEFAULT_ACCOUNT', 'default'),

    'accounts' => [
        'default' => [
            'host'          => env('IMAP_HOST', 'localhost'),
            'port'          => env('IMAP_PORT', 993),
            'protocol'      => env('IMAP_PROTOCOL', 'imap'),
            'encryption'    => env('IMAP_ENCRYPTION', 'ssl'),
            'validate_cert' => env('IMAP_VALIDATE_CERT', true),
            'username'      => env('IMAP_USERNAME', ''),
            'password'      => env('IMAP_PASSWORD', ''),
            'authentication' => env('IMAP_AUTHENTICATION', null),
        ],
    ],

    'date_format' => 'd.m.Y',
    'options' => [
        'delimiter' => '/',
        'fetch' => \Webklex\PHPIMAP\IMAP::FT_UID,
        'fetch_body' => true,
        'fetch_flags' => true,
        'message_key' => 'id',
        'fetch_order' => 'asc',
        'open' => [],
        'decoder' => [
            'message' => ['subject' => 'utf-8'],
            'attachment' => ['name' => 'utf-8'],
        ],
        'common_folders' => [
            'root' => 'INBOX',
            'junk' => 'INBOX/Junk',
            'draft' => 'INBOX/Drafts',
            'sent' => 'INBOX/Sent',
            'trash' => 'INBOX/Trash',
            'spam' => 'INBOX/Spam',
        ],
    ],

    'events' => [
        'message' => [
            'new' => \Webklex\PHPIMAP\Events\MessageNewEvent::class,
            'moved' => \Webklex\PHPIMAP\Events\MessageMovedEvent::class,
            'copied' => \Webklex\PHPIMAP\Events\MessageCopiedEvent::class,
            'deleted' => \Webklex\PHPIMAP\Events\MessageDeletedEvent::class,
            'restored' => \Webklex\PHPIMAP\Events\MessageRestoredEvent::class,
        ],
        'folder' => [
            'new' => \Webklex\PHPIMAP\Events\FolderNewEvent::class,
            'moved' => \Webklex\PHPIMAP\Events\FolderMovedEvent::class,
            'deleted' => \Webklex\PHPIMAP\Events\FolderDeletedEvent::class,
        ],
        'flag' => [
            'new' => \Webklex\PHPIMAP\Events\FlagNewEvent::class,
            'deleted' => \Webklex\PHPIMAP\Events\FlagDeletedEvent::class,
        ],
    ],

    'masks' => [
        'message' => \Webklex\PHPIMAP\Support\Masks\MessageMask::class,
        'attachment' => \Webklex\PHPIMAP\Support\Masks\AttachmentMask::class,
    ],
];
