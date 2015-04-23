ALTER TABLE res_letterbox ADD tnl_path character varying(255) DEFAULT NULL::character varying;
ALTER TABLE res_letterbox ADD tnl_filename character varying(255) DEFAULT NULL::character varying;

INSERT INTO docserver_types (docserver_type_id, docserver_type_label, enabled, is_container, container_max_number, is_compressed, compression_mode, is_meta, meta_template, is_logged, log_template, is_signed, fingerprint_mode) VALUES ('TNL', 'Thumbnails', 'Y', 'N', 0, 'N', 'NONE', 'N', 'NONE', 'N', 'NONE', 'Y', 'NONE');
INSERT INTO docservers (docserver_id, docserver_type_id, device_label, is_readonly, enabled, size_limit_number, actual_size_number, path_template, ext_docserver_info, chain_before, chain_after, creation_date, closing_date, coll_id, priority_number, docserver_location_id, adr_priority_number) VALUES ('TNL_MLB', 'TNL', '[courrier] Server for thumbnails of documents', 'N', 'Y', 50000000000, 0, '/opt/maarch/docservers/TNL_MLB/', NULL, NULL, NULL, '2015-03-16 14:47:49.197164', NULL, 'letterbox_coll', 11, 'NANTERRE', 3);