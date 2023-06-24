create table messages
(
    id bigint auto_increment,
    message text null,
    constraint messages_pk
        primary key (id)
);