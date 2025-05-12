insert into positions (title) values
('TECH_SUPPORT_EXECUTIVE'),
('GROWTH_HACKER'),
('SOFTWARE_DEVELOPER'),
('DEVOPS_ENGINEER');

insert into employees (
    self_id,
    first_name,
    last_name,
    current_address,
    position_id,
    is_active
) values
(1, 'John', 'Smith', 'USA', 3, true),
(2, 'Samantha', 'Argonian', 'Byzantine', 2, false),
(3, 'Arthur', 'Blitzed', 'Armenia', 1, false);
