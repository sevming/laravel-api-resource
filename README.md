<h1 align="center">laravel-api-resource</h1>

## Requirement
1. PHP >= 7.4
2. [Composer](https://getcomposer.org/)

## Installing
```shell
$ composer require sevming/laravel-api-resource -vvv
```

## Usage
> 说明事项
+ 建议与 [sevming/laravel-response](https://github.com/sevming/laravel-response) 配合使用 
+ 支持资源、集合、分页、自定义分页的数据处理
+ show() 的优先级大于 hide()
+ 列表数据处理（MockUserResource 资源类）
    - MockUserResource::collection($list)
    - MockUserCollection::make($list)

> 资源
+ MockUserResource
    ```php
    <?php
    
    namespace App\Http\Resources\Mock;
    
    use Sevming\LaravelApiResource\BaseResource;
    
    class MockUserResource extends BaseResource
    {
        public const SCENE_LIST = 'list';
    
        public const SCENE_INFO = 'info';
    
        public function toArray($request)
        {
            switch ($this->scene) {
                case self::SCENE_LIST:
                    $this->show(['id', 'account']);
                    break;
                case self::SCENE_INFO:
                    $this->hide(['password']);
                    break;
                default:
                    break;
            }
    
            return $this->filterFields([
                'id' => $this->id,
                'account' => $this->account,
                'password' => $this->password,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]);
        }
    
        public function with($request)
        {
            return [
                'with' => 'with resource',
            ];
        }
    }
    
    ```
+ 调用示例
    ```php
    $user = MockUser::find(1);
    
    return MockUserResource::make($user);
    return MockUserResource::make($user)->show(['id']);
    return MockUserResource::make($user)->hide(['id']);
    return MockUserResource::make($user)->scene(MockUserResource::SCENE_LIST);
    return MockUserResource::make($user)
        ->scene(MockUserResource::SCENE_LIST)
        ->show(['created_at'])
        ->additional([
            'additional' => 'additional resource'
        ]);
    ```

> 集合
+ 调用示例
    ```php
    $list = MockUser::get();

    return MockUserResource::collection($list);
    return MockUserResource::collection($list)->show(['id']);
    return MockUserResource::collection($list)->hide(['id']);
    return MockUserResource::collection($list)->scene(MockUserResource::SCENE_LIST);
    return MockUserResource::collection($list)
        ->scene(MockUserResource::SCENE_LIST)
        ->show(['created_at'])
        ->additional([
            'additional' => 'additional collection'
        ]);
    ```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/sevming/laravel-api-resource/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/sevming/laravel-api-resource/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT