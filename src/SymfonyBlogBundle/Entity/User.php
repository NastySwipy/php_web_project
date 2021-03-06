<?php

namespace SymfonyBlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="SymfonyBlogBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Email(
     *     message = "Invalid email.",
     *     checkMX = true
     * )
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/",
     *     match=true,
     *     message="Please enter a valid password (small letters and digits)"
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Your password must be at least 4 characters long",
     *      maxMessage = "Your password cannot be longer than 10 characters"
     * )
     *
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SymfonyBlogBundle\Entity\Article", mappedBy="author", cascade={"remove"})
     */
    private $articles;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SymfonyBlogBundle\Entity\Product", mappedBy="author", cascade={"remove"})
     */
    private $products;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="SymfonyBlogBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *     )
     */
    private $roles;

    /**
     * @var ArrayCollection| Comment[]
     *
     *@ORM\OneToMany(targetEntity="SymfonyBlogBundle\Entity\Comment", mappedBy="author", cascade={"remove"})
     */
    private $comments;


    /**
     * @var ArrayCollection|Message[]
     *
     * @ORM\OneToMany(targetEntity="SymfonyBlogBundle\Entity\Message", mappedBy="sender")
     */
    private $senders;

    /**
     * @var ArrayCollection|Message[]
     *
     * @ORM\OneToMany(targetEntity="SymfonyBlogBundle\Entity\Message", mappedBy="recipient")
     */
    private $recipients;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->dateCreated = new \DateTime('now');
        $this->comments = new ArrayCollection();
        $this->senders = new ArrayCollection();
        $this->recipients = new ArrayCollection();
    }


    /**
     * @return ArrayCollection|Message[]
     */
    public function getSendersMessages()
    {
        return $this->senders;
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getRecipientsMessages()
    {
        return $this->recipients;
    }



    /**
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment|null $comment
     * @return User
     */
    public function addComment(Comment $comment = null)
    {
        $this->comments[] = $comment;
        return $this;
    }



    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }


    /**
     * @param Article
     *
     * @return User
     */
    public function addPost($article)
    {
        $this->articles = $article;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product
     *
     * @return User
     */
    public function addProduct($product)
    {
        $this->products = $product;
        return $this;
    }




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $stringRoles = [];

        foreach ($this->roles as $role) {
            /** @var Role $role*/
            $stringRoles[] = $role->getRole();
        }
        return $stringRoles;
    }

    /**
     * @param Role $role
     *
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;

    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }



    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getShortName()
    {
        $shortName = explode(' ',$this->fullName);
        return $shortName[0];

    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isAuthor(Article $article)
    {
        return $article->getAuthorId() === $this->getId();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->getRoles(), true);
    }
}

