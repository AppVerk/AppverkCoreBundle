<?php
namespace Cube\CoreBundle\Entity;

use Sonata\ClassificationBundle\Entity\CategoryManager as BaseCategoryManager;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\ClassificationBundle\Model\ContextInterface;

class CategoryManager extends BaseCategoryManager
{
    /**
     * @param ContextInterface $context
     *
     * @return CategoryInterface
     */
    public function getRootCategory($context = null)
    {
        $context = $this->getContext($context);
        $this->loadCategories($context);
        return $this->categories[$context->getId()][0];
    }

    /**
     * @param ContextInterface|null $context
     *
     * @return array
     */
    public function getCategories($context = null)
    {
        $context = $this->getContext($context);
        $this->loadCategories($context);
        return $this->categories[$context->getId()];
    }

    /**
     * @param $contextCode
     *
     * @return ContextInterface
     */
    private function getContext($contextCode)
    {
        if (empty($contextCode)) {
            $contextCode = ContextInterface::DEFAULT_CONTEXT;
        }
        if ($contextCode instanceof ContextInterface) {
            return $contextCode;
        }
        $context = $this->contextManager->findOneBy([
            'name' => $contextCode
        ]);
        if (!$context instanceof ContextInterface) {
            $context = $this->contextManager->create();
            $context->setId($contextCode);
            $context->setName($contextCode);
            $context->setEnabled(true);
            $this->contextManager->save($context);
        }
        return $context;
    }

    public function getRootCategories($loadChildren = true)
    {
        $class = $this->getClass();
        $rootCategories = $this->getObjectManager()->createQuery(sprintf('SELECT c FROM %s c WHERE c.parent IS NULL', $class))
            ->execute();
        $categories = array();
        /** @var Category $category */
        foreach ($rootCategories as $category) {
            if ($category->getContext() === null) {
                throw new \RuntimeException('Context cannot be null');
            }
            $categories[$category->getSlug()] = $loadChildren ? $this->getRootCategory($category->getContext()) : $category;
        }
        return $categories;
    }
}
