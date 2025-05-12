create table positions (
    id int auto_increment,
    title varchar(30) unique not null,
    primary key (id)
);

create table employees (
    id int auto_increment,
    self_id int not null unique check (self_id > 0),
    first_name varchar(15) not null,
    middle_name varchar(15),
    last_name varchar(15) not null,
    permanent_address varchar(20),
    current_address varchar(20),
    position_id int not null,
    is_active boolean not null default (false),
    joining_date date not null default (current_date),
    primary key (id),
    foreign key (position_id) references positions (id)
);
