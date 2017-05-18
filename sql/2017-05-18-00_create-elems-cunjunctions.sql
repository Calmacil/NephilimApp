/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  calmacil
 * Created: 18 mai 2017
 */

ALTER TABLE `event` ADD PRIMARY KEY `date`;

CREATE TABLE `ka` (
    `id` VARCHAR(3) PRIMARY KEY,
    `name` VARCHAR(16),
);

INSERT INTO `ka` (`id`, `name`) VALUES
    ('TER', 'Terre'),
    ('FEU', 'Feu'),
    ('AIR', 'Air'),
    ('EAU', 'Eau'),
    ('LUN', 'Lune'),
    ('SOL', 'Soleil'),
    ('KLN', 'Lune Noire'),
    ('KSN', 'Soleil Noir'),
    ('ORI', 'Orichalque'),
    ('ADA', 'Adamante'),
    ('KHB', 'Khaiba'),
    ('BRU', 'Brume'),
    ('KLO', 'Lune originelle');

CREATE TABLE `ephemeris` (
    `id` TINYINT PRIMARY KEY AUTO_INCREMENT,
    `zodiac_name` VARCHAR(16) NOT NULL,
    `ka_id` VARCHAR(3) NOT NULL,
    `start_day` TINYINT,
    `start_month` TINYINT,
    `end_day` TINYINT,
    `end_month` TINYINT,
)

INSERT INTO `ephemeris` (`zodiac_name`, `ka_id`, `start_day`, `start_month`, `end_day`, `end_month`) VALUES
    ('Bélier', 'FEU', 21, 3, 20, 4),
    ('Taureau', 'TER', 21, 4, 20, 5),
    ('Gémeaux', 'EAU', 21, 5, 20, 6),
    ('Cancer', 'LUN', 21, 6, 22, 7),
    ('Lion', 'SOL', 23, 7, 22, 8),
    ('Vierge', 'EAU', 23, 8, 22, 9),
    ('Balance', 'TER', 23, 9, 22, 10),
    ('Scorpion', 'FEU', 23, 10, 21, 11),
    ('Sagitaire', 'AIR', 22, 11, 20, 12),
    ('Capricorne', 'LUN', 21, 12, 19, 1),
    ('Verseau', 'ORI', 20, 1, 18, 2),
    ('Poissons', 'AIR', 19, 2, 20, 3);