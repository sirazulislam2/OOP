*/2 * * * * /user/local/src/scripts/email.php /path/to/cron.php >/dev/null 2>&1

<?php

require_once __DIR__ . '/vendor/autoload.php';

// Write folder content to log every five minutes.
$job1 = new \Cron\Job\ShellJob();
$job1->setCommand('ls -la /path/to/folder');
$job1->setSchedule(new \Cron\Schedule\CrontabSchedule('*/5 * * * *'));

// Remove folder contents every hour.
$job2 = new \Cron\Job\ShellJob();
$job2->setCommand('rm -rf /path/to/folder/*');
$job2->setSchedule(new \Cron\Schedule\CrontabSchedule('0 0 * * *'));

$resolver = new \Cron\Resolver\ArrayResolver();
$resolver->addJob($job1);
$resolver->addJob($job2);

$cron = new \Cron\Cron();
$cron->setExecutor(new \Cron\Executor\Executor());
$cron->setResolver($resolver);

$cron->run();