use deadcode;

create table called_code
(
    id             int auto_increment
        primary key,
    request_uri    text                                   null,
    request_method char(10)                               null,
    function       text                                   not null,
    location       text                                   not null,
    server_name    char(255)                              null,
    server_ip      char(50)                               not null,
    app_name       char(255)                              not null,
    env            char(255)                              not null,
    client_ip      char(50)                               null,
    accessed_at    datetime default '0000-00-00 00:00:00' not null on update current_timestamp()
);
