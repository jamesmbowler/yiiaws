<?php
/**
 * A2Base
 *
 * Base class. This class handles service initalization and services.
 * @see config/aws-config
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package A2.amazon.components
 */

use Aws\Common\Aws;
use Guzzle\Inflection\Inflector;

abstract class A2Base extends CComponent
{
	const AWS_AUTOSCALING 			= 'autoscaling';
	const AWS_CLOUDFRONT 			= 'cloudfront';
	const AWS_CLOUDWATCH 			= 'cloudwatch';
	const AWS_DATAPIPELINE 			= 'datapipeline';
	const AWS_DYNAMODB 				= 'dynamodb';
	const AWS_EC2 					= 'ec2';
	const AWS_ELASTIC_BEANSTALK 	= 'elasticbeanstalk';
	const AWS_ELASTIC_LOADBALANCING = 'elasticloadbalancing';
	const AWS_ELASTIC_TRANSCODER 	= 'elastictranscoder';
	const AWS_GLACIER 				= 'glacier';
	const AWS_IAM 					= 'iam';
	const AWS_OPSWORKS 				= 'opsworks';
	const AWS_RDS 					= 'rds';
	const AWS_REDSHIFT 				= 'redshift';
	const AWS_ROUTE53 				= 'route53';
	const AWS_S3 					= 's3';
	const AWS_SES 					= 'ses';
	const AWS_SIMPLEDB 				= 'simpledb';
	const AWS_SNS 					= 'sns';
	const AWS_SQS 					= 'sqs';
	const AWS_STS 					= 'sts';
	const AWS_SWF 					= 'swf';


	protected $_aws;

	protected $_client;

	/**
	 * Returns the aws service builder
	 * @return Guzzle\Service\Builder\ServiceBuilder
	 */
	public function getAws()
	{
		if (null === $this->_aws)
		{
			$config = __DIR__ . '/../config/aws-config.php';
			if (!@file_exists($config))
				throw new CException(Yii::t('zii', '"aws-config.php" configuration file not found'));

			$this->_aws = Aws::factory($config);
		}

		return $this->_aws;
	}

	/**
	 * Magic call to wrapped amazon aws methods. If not command found, then call parent component
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		try
		{
			$command_args = count($args)
				? $args[0]
				: $args;

			$command = $this->getClient()
				->getCommand(Inflector::getDefault()->camel($method), $command_args);

			if ($command)
				return $this->getClient()->execute($command, $command_args);

		} catch(Exception $e) {

			throw new CException(Yii::t('zii', $e->getMessage()));
		}
		return parent::__call($method, $args);
	}

	abstract public function getClient();
}