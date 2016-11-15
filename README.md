# Installation

Require the bundle with composer:

```
...
"require": {
        ...
        "app-verk/core-bundle": "dev-master"
    },
"repositories": [
        {
            "url": "https://github.com/art4webs/AppverkCoreBundle.git",
            "type": "vcs"
        }
    ],
```

Enable the bundle in the AppKernel:
```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Cube\CoreBundle\CubeCoreBundle(),
        // ...
    );
}
```

# Create entites classes

```
<?php

// AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Cube\CoreBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="cube_core_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
```

```
<?php
// AppBundle/Entity/Group.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_user_group")
 */
class Group extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
```

```
<?php
// AppBundle/Entity/Media.php

namespace AppBundle\Entity;

use Cube\CoreBundle\Entity\Media as BaseMedia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_media")
 */
class Media extends BaseMedia
{
}
```

# Configuration

Add new file to your config directory: cube_parameters.yml

```
parameters:
    cube_core_entity_user: AppBundle\Entity\User
    cube_core_entity_group: AppBundle\Entity\Group
    cube_core_entity_media: AppBundle\Entity\Media
```

Add import files to main config file:
```
...
    - { resource: cube_parameters.yml }
    - { resource: '@CubeCoreBundle/Resources/config/main.yml' }
...
```

Now u are ready to go!
