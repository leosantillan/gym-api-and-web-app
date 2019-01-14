CREATE TABLE `days` (
    id int NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `exercises` (
    id int NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `day_exercises` (
    id int NOT NULL AUTO_INCREMENT,
    id_day int NOT NULL,
    id_exercise int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_day) REFERENCES `days`(id) ON DELETE CASCADE,
    FOREIGN KEY (id_exercise) REFERENCES `exercises`(id) ON DELETE CASCADE
);

CREATE TABLE `plans` (
    id int NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `plan_days` (
    id int NOT NULL AUTO_INCREMENT,
    id_plan int NOT NULL,
    id_day int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_plan) REFERENCES `plans`(id) ON DELETE CASCADE,
    FOREIGN KEY (id_day) REFERENCES `days`(id) ON DELETE CASCADE
);

CREATE TABLE `users` (
    id int NOT NULL AUTO_INCREMENT,
    `firstname` varchar(64) NOT NULL,
    `lastname` varchar(64) NOT NULL,
    `email` varchar(128) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `user_plans` (
    id int NOT NULL AUTO_INCREMENT,
    id_user int NOT NULL,
    id_plan int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES `users`(id) ON DELETE CASCADE,
    FOREIGN KEY (id_plan) REFERENCES `plans`(id) ON DELETE CASCADE
);
