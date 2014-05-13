<?php
/**
 * AWS configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package A2.amazon.components
 */

return array(
	'includes' => array('_aws'),
	'services' => array(
		'default_settings' => array(
			'params' => array(
				'key'    => AWS_ACCESS_KEY_ID,
				'secret' => AWS_SECRET_KEY,
				'region' => AWS_REGION
			)
		)
	)
);
