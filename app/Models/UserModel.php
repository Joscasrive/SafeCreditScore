<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Cuentas locales del portal de miembros.
 *
 * La cuenta se crea al final del flujo de enrolamiento con Array (ver
 * Enroll::finish()) y es lo que permite a un cliente volver a iniciar
 * sesion sin repetir la verificacion KBA cada vez.
 */
class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    protected $allowedFields = [
        'full_name',
        'email',
        'password_hash',
        'array_user_id',
        'array_enrolled_at',
        'status',
        'last_login_at',
    ];

    protected $validationRules = [
        'full_name' => 'required|min_length[2]|max_length[150]',
        'email'     => 'required|valid_email|max_length[190]|is_unique[users.email,id,{id}]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Ya existe una cuenta registrada con ese correo.',
        ],
    ];

    protected $beforeInsert = ['normalizeEmail'];
    protected $beforeUpdate = ['normalizeEmail'];

    /**
     * @param array{data: array<string,mixed>} $row
     *
     * @return array{data: array<string,mixed>}
     */
    protected function normalizeEmail(array $row): array
    {
        if (isset($row['data']['email'])) {
            $row['data']['email'] = trim(strtolower((string) $row['data']['email']));
        }

        return $row;
    }

    /**
     * Crea la cuenta hasheando la contrasena en texto plano recibida.
     *
     * @param array<string,mixed> $data Debe incluir 'password' en texto plano.
     *
     * @return int|false ID insertado, o false si fallo la validacion.
     */
    public function createWithPassword(array $data): int|false
    {
        $plainPassword = (string) ($data['password'] ?? '');
        unset($data['password'], $data['password_confirm']);

        $data['password_hash'] = password_hash($plainPassword, PASSWORD_DEFAULT);

        $id = $this->insert($data, true);

        return $id === false ? false : (int) $id;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', trim(strtolower($email)))->first();
    }

    public function findByArrayUserId(string $arrayUserId): ?array
    {
        return $this->where('array_user_id', $arrayUserId)->first();
    }

    public function verifyPassword(array $user, string $plainPassword): bool
    {
        return password_verify($plainPassword, (string) ($user['password_hash'] ?? ''));
    }

    public function touchLastLogin(int $id): void
    {
        $this->update($id, ['last_login_at' => date('Y-m-d H:i:s')]);
    }
}
