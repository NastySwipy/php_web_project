<?php

namespace SymfonyBlogBundle\Repository;


/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends \Doctrine\ORM\EntityRepository
{
    public function makeAdmin($id)
    {

        $em = $this->getEntityManager();

        $RAW_QUERY = 'UPDATE `symfony_blog`.`users_roles` SET `role_id`= 1 WHERE  `user_id`= :id AND `role_id`=2';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function makeUser($id)
    {
        $em = $this->getEntityManager();
        $RAW_QUERY = 'UPDATE `symfony_blog`.`users_roles` SET `role_id`= 2 WHERE  `user_id`= :id AND `role_id`=1';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function removeUserRole($id)
    {
        $em = $this->getEntityManager();
        $RAW_QUERY = 'DELETE FROM `symfony_blog`.`users_roles` WHERE  `user_id`= :id AND `role_id`=2';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function removeUserComments($id)
    {
        $em = $this->getEntityManager();
        $RAW_QUERY2 = 'DELETE FROM `symfony_blog`.`comments` WHERE `author_id` = :id';

        $statement = $em->getConnection()->prepare($RAW_QUERY2);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function removeUserMsg($id)
    {
        $em = $this->getEntityManager();
        $RAW_QUERY2 = 'DELETE FROM `symfony_blog`.`messages` WHERE `recipient_id` = :id OR `sender_id` = :id';

        $statement = $em->getConnection()->prepare($RAW_QUERY2);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function removeUserArticle($id)
    {
        $em = $this->getEntityManager();
        $RAW_QUERY2 = 'DELETE FROM `symfony_blog`.`articles` WHERE  `authorId`= :id';

        $statement = $em->getConnection()->prepare($RAW_QUERY2);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function removeUser($id)
    {

        $em = $this->getEntityManager();

//        $RAW_QUERY = 'UPDATE `symfony_blog`.`users_roles` SET `role_id`= 2 WHERE  `user_id`= :id AND `role_id`=1';
        $RAW_QUERY2 = 'DELETE FROM `symfony_blog`.`users` WHERE  `id`= :id';

        $statement = $em->getConnection()->prepare($RAW_QUERY2);
        // Set parameters
        $statement->bindValue('id', $id);
        $statement->execute();

    }
}
