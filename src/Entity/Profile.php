<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sentBy', 'show_requests', "show_profiles", "show_friends",'show_privateConversations', 'show_receivedrequests', 'show_groupConv'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['sentBy', 'show_requests', "show_profiles", "show_friends", 'show_privateConversations', 'show_privateConversationMessages',"show_receivedRequests", 'show_groupConv'])]
    private ?string $username = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ofUser = null;


    # Friend Request
    #[ORM\OneToMany(mappedBy: 'ofProfile', targetEntity: FriendRequest::class)]
    #[Groups(['sentBy'])]
    private Collection $receivedFriendRequests;

    #[ORM\OneToMany(mappedBy: 'toProfile', targetEntity: FriendRequest::class)]
    private Collection $sentFriendRequests;


    # Friendship
    #[ORM\OneToMany(mappedBy: 'friendA', targetEntity: Friendship::class)]
    private Collection $relationAsSender;

    #[ORM\OneToMany(mappedBy: 'friendB', targetEntity: Friendship::class)]
    private Collection $relationAsRecipient;


    # Private Chat
    #[ORM\OneToMany(mappedBy: 'participantA', targetEntity: PrivateConversation::class)]

    private Collection $participantAOfPrivateChat;

    #[ORM\OneToMany(mappedBy: 'participantB', targetEntity: PrivateConversation::class)]
    private Collection $participantBOfPrivateChat;

    # Private Messages
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: PrivateMessage::class, orphanRemoval: true)]
    private Collection $sentPrivateMessages;

    #[ORM\Column]
    #[Groups(['show_profiles'])]
    private ?bool $public = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lastName = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: GroupConversation::class)]
    private Collection $createdPublicConversations;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: GroupConversation::class)]
    private Collection $adminPublicConversations;

    #[ORM\ManyToMany(targetEntity: GroupConversation::class, mappedBy: 'members')]
    private Collection $groupConversations;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: GroupMessage::class)]
    private Collection $groupMessages;



    public function __construct()
    {
        $this->receivedFriendRequests = new ArrayCollection();
        $this->sentFriendRequests = new ArrayCollection();
        $this->relationAsSender = new ArrayCollection();
        $this->relationAsRecipient = new ArrayCollection();
        $this->participantAOfPrivateChat = new ArrayCollection();
        $this->participantBOfPrivateChat = new ArrayCollection();
        $this->sentPrivateMessages = new ArrayCollection();
        $this->createdPublicConversations = new ArrayCollection();
        $this->adminPublicConversation = new ArrayCollection();
        $this->publicConversations = new ArrayCollection();
        $this->groupConversations = new ArrayCollection();
        $this->groupMessages = new ArrayCollection();
    }

    public function getFriendList(){
        $friendList = [];
        $currentProfile = $this;

        foreach($currentProfile->relationAsSender as $relation){
            if($relation->getFriendA() != $currentProfile){
                $otherPerson = $relation->getFriendA();
            }elseif($relation->getFriendB() != $currentProfile){
                $otherPerson = $relation->getFriendB();
            }
            $friendList[]= $otherPerson;
        }
        foreach($currentProfile->relationAsRecipient as $relation){
            if($relation->getFriendA() != $currentProfile){
                $otherPerson = $relation->getFriendA();
            }elseif($relation->getFriendB() != $currentProfile){
                $otherPerson = $relation->getFriendB();
            }
            $friendList[]= $otherPerson;
        }

        return $friendList;
    }

    public function getPrivateConversations(){
        $privateConversations = [];
        $currentProfile = $this;

        // lalala

        return $privateConversations;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     */
    public function getReceivedFriendRequests(): Collection
    {
        return $this->receivedFriendRequests;
    }

    public function addReceivedFriendRequest(FriendRequest $receivedFriendRequest): static
    {
        if (!$this->receivedFriendRequests->contains($receivedFriendRequest)) {
            $this->receivedFriendRequests->add($receivedFriendRequest);
            $receivedFriendRequest->setOfProfile($this);
        }

        return $this;
    }

    public function removeReceivedFriendRequest(FriendRequest $receivedFriendRequest): static
    {
        if ($this->receivedFriendRequests->removeElement($receivedFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($receivedFriendRequest->getOfProfile() === $this) {
                $receivedFriendRequest->setOfProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     */
    public function getSentFriendRequests(): Collection
    {
        return $this->sentFriendRequests;
    }

    public function addSentFriendRequest(FriendRequest $sentFriendRequest): static
    {
        if (!$this->sentFriendRequests->contains($sentFriendRequest)) {
            $this->sentFriendRequests->add($sentFriendRequest);
            $sentFriendRequest->setToProfile($this);
        }

        return $this;
    }

    public function removeSentFriendRequest(FriendRequest $sentFriendRequest): static
    {
        if ($this->sentFriendRequests->removeElement($sentFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($sentFriendRequest->getToProfile() === $this) {
                $sentFriendRequest->setToProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getRelationAsSender(): Collection
    {
        return $this->relationAsSender;
    }

    public function addRelationAsSender(Friendship $relationAsSender): static
    {
        if (!$this->relationAsSender->contains($relationAsSender)) {
            $this->relationAsSender->add($relationAsSender);
            $relationAsSender->setFriendA($this);
        }

        return $this;
    }

    public function removeRelationAsSender(Friendship $relationAsSender): static
    {
        if ($this->relationAsSender->removeElement($relationAsSender)) {
            // set the owning side to null (unless already changed)
            if ($relationAsSender->getFriendA() === $this) {
                $relationAsSender->setFriendA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getRelationAsRecipient(): Collection
    {
        return $this->relationAsRecipient;
    }

    public function addRelationAsRecipient(Friendship $relationAsRecipient): static
    {
        if (!$this->relationAsRecipient->contains($relationAsRecipient)) {
            $this->relationAsRecipient->add($relationAsRecipient);
            $relationAsRecipient->setFriendB($this);
        }

        return $this;
    }

    public function removeRelationAsRecipient(Friendship $relationAsRecipient): static
    {
        if ($this->relationAsRecipient->removeElement($relationAsRecipient)) {
            // set the owning side to null (unless already changed)
            if ($relationAsRecipient->getFriendB() === $this) {
                $relationAsRecipient->setFriendB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrivateConversation>
     */
    public function getParticipantAOfPrivateChat(): Collection
    {
        return $this->participantAOfPrivateChat;
    }

    public function addParticipantAOfPrivateChat(PrivateConversation $participantAOfPrivateChat): static
    {
        if (!$this->participantAOfPrivateChat->contains($participantAOfPrivateChat)) {
            $this->participantAOfPrivateChat->add($participantAOfPrivateChat);
            $participantAOfPrivateChat->setParticipantA($this);
        }

        return $this;
    }

    public function removeParticipantAOfPrivateChat(PrivateConversation $participantAOfPrivateChat): static
    {
        if ($this->participantAOfPrivateChat->removeElement($participantAOfPrivateChat)) {
            // set the owning side to null (unless already changed)
            if ($participantAOfPrivateChat->getParticipantA() === $this) {
                $participantAOfPrivateChat->setParticipantA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrivateConversation>
     */
    public function getParticipantBOfPrivateChat(): Collection
    {
        return $this->participantBOfPrivateChat;
    }

    public function addParticipantBOfPrivateChat(PrivateConversation $participantBOfPrivateChat): static
    {
        if (!$this->participantBOfPrivateChat->contains($participantBOfPrivateChat)) {
            $this->participantBOfPrivateChat->add($participantBOfPrivateChat);
            $participantBOfPrivateChat->setParticipantB($this);
        }

        return $this;
    }

    public function removeParticipantBOfPrivateChat(PrivateConversation $participantBOfPrivateChat): static
    {
        if ($this->participantBOfPrivateChat->removeElement($participantBOfPrivateChat)) {
            // set the owning side to null (unless already changed)
            if ($participantBOfPrivateChat->getParticipantB() === $this) {
                $participantBOfPrivateChat->setParticipantB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrivateMessage>
     */
    public function getSentPrivateMessages(): Collection
    {
        return $this->sentPrivateMessages;
    }

    public function addSentPrivateMessage(PrivateMessage $sentPrivateMessage): static
    {
        if (!$this->sentPrivateMessages->contains($sentPrivateMessage)) {
            $this->sentPrivateMessages->add($sentPrivateMessage);
            $sentPrivateMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeSentPrivateMessage(PrivateMessage $sentPrivateMessage): static
    {
        if ($this->sentPrivateMessages->removeElement($sentPrivateMessage)) {
            // set the owning side to null (unless already changed)
            if ($sentPrivateMessage->getAuthor() === $this) {
                $sentPrivateMessage->setAuthor(null);
            }
        }

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, GroupConversation>
     */
    public function getCreatedPublicConversations(): Collection
    {
        return $this->createdPublicConversations;
    }

    public function addCreatedPublicConversation(GroupConversation $createdPublicConversation): static
    {
        if (!$this->createdPublicConversations->contains($createdPublicConversation)) {
            $this->createdPublicConversations->add($createdPublicConversation);
            $createdPublicConversation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedPublicConversation(GroupConversation $createdPublicConversation): static
    {
        if ($this->createdPublicConversations->removeElement($createdPublicConversation)) {
            // set the owning side to null (unless already changed)
            if ($createdPublicConversation->getCreatedBy() === $this) {
                $createdPublicConversation->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupConversation>
     */
    public function getAdminPublicConversations(): Collection
    {
        return $this->adminPublicConversation;
    }

    public function addAdminPublicConversation(GroupConversation $adminPublicConversation): static
    {
        if (!$this->adminPublicConversation->contains($adminPublicConversation)) {
            $this->adminPublicConversation->add($adminPublicConversation);
            $adminPublicConversation->setAdmin($this);
        }

        return $this;
    }

    public function removeAdminPublicConversation(GroupConversation $adminPublicConversation): static
    {
        if ($this->adminPublicConversation->removeElement($adminPublicConversation)) {
            // set the owning side to null (unless already changed)
            if ($adminPublicConversation->getAdmin() === $this) {
                $adminPublicConversation->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupConversation>
     */
    public function getGroupConversations(): Collection
    {
        return $this->groupConversations;
    }

    public function addGroupConversation(GroupConversation $groupConversation): static
    {
        if (!$this->groupConversations->contains($groupConversation)) {
            $this->groupConversations->add($groupConversation);
            $groupConversation->addMember($this);
        }

        return $this;
    }

    public function removeGroupConversation(GroupConversation $groupConversation): static
    {
        if ($this->groupConversations->removeElement($groupConversation)) {
            $groupConversation->removeMember($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupMessage>
     */
    public function getGroupMessages(): Collection
    {
        return $this->groupMessages;
    }

    public function addGroupMessage(GroupMessage $groupMessage): static
    {
        if (!$this->groupMessages->contains($groupMessage)) {
            $this->groupMessages->add($groupMessage);
            $groupMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeGroupMessage(GroupMessage $groupMessage): static
    {
        if ($this->groupMessages->removeElement($groupMessage)) {
            // set the owning side to null (unless already changed)
            if ($groupMessage->getAuthor() === $this) {
                $groupMessage->setAuthor(null);
            }
        }

        return $this;
    }






}
