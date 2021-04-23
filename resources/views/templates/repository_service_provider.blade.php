/*
* use
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;
use App\Infrastructure\PostgresRepository\Eloquent{{ $entityName }}Repository;
* repository
        $this->app->singleton(
            {{ $entityName }}RepositoryInterface::class,
            Eloquent{{ $entityName }}Repository::class
        );
*/
