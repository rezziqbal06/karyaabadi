ALTER TABLE `a_unit` CHANGE `is_active` `is_active` INT(1) NOT NULL DEFAULT '1';
ALTER TABLE `a_jpenilaian` CHANGE `is_active` `is_active` INT(1) NOT NULL DEFAULT '1';
ALTER TABLE `a_indikator` CHANGE `is_active` `is_active` INT(1) NOT NULL DEFAULT '1';
ALTER TABLE `a_unit` CHANGE `is_active` `is_active` INT(1) NOT NULL DEFAULT '1';
ALTER TABLE `c_asesmen` CHANGE `is_active` `is_active` INT(1) NOT NULL DEFAULT '1';

ALTER TABLE `a_unit` CHANGE `is_deleted` `is_deleted` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `a_jpenilaian` CHANGE `is_deleted` `is_deleted` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `a_indikator` CHANGE `is_deleted` `is_deleted` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `a_unit` CHANGE `is_deleted` `is_deleted` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `c_asesmen` CHANGE `is_deleted` `is_deleted` INT(1) NOT NULL DEFAULT '0';