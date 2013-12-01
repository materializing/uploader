<?php
Router::connect('/files/uploads/*', array('plugin' => 'uploader', 'controller' => 'uploader_files', 'action' => 'view_limited_file'));