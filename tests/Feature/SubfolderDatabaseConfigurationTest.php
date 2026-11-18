<?php

namespace Tests\\Feature;

use Tests\\TestCase;

final class SubfolderDatabaseConfigurationTest extends TestCase
{
    public function test_sqlite_remains_the_local_and_ci_default(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame('sqlite', config('database.connections.sqlite.driver'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
    }

    public function test_mysql_connection_is_configurable_for_a_separate_hosted_v2_database(): void
    {
        config([
            'database.connections.mysql.host' => 'v2-db.synthetic.invalid',
            'database.connections.mysql.port' => '3306',
            'database.connections.mysql.database' => 'synthetic_v2_database',
            'database.connections.mysql.username' => 'synthetic_v2_user',
            'database.connections.mysql.password' => 'synthetic-v2-only-password',
        ]);

        $this->assertSame('mysql', config('database.connections.mysql.driver'));
        $this->assertSame('v2-db.synthetic.invalid', config('database.connections.mysql.host'));
        $this->assertSame('3306', config('database.connections.mysql.port'));
        $this->assertSame('synthetic_v2_database', config('database.connections.mysql.database'));
        $this->assertSame('synthetic_v2_user', config('database.connections.mysql.username'));
        $this->assertSame('synthetic-v2-only-password', config('database.connections.mysql.password'));
        $this->assertSame('utf8mb4', config('database.connections.mysql.charset'));
        $this->assertTrue(config('database.connections.mysql.strict'));
    }

    public function test_session_cookie_can_be_scoped_to_the_v2_subfolder(): void
    {
        config([
            'session.cookie' => 'estudent-institutes-v2-session',
            'session.path' => '/v2',
        ]);

        $this->assertSame('estudent-institutes-v2-session', config('session.cookie'));
        $this->assertSame('/v2', config('session.path'));
    }
}
