<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Comment;
use App\Models\PlayerViewCount;
use App\Repositories\PlayerProfileRepoInt;

class PlayerService
{
    protected $playerRepository;

    public function __construct(PlayerProfileRepoInt $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function increaseViewCount($id)
    {
        $viewCountEntry = PlayerViewCount::where('player_id', $id)->first();

        if ($viewCountEntry) {
            $viewCountEntry->increment('view_count');
        } else {
            PlayerViewCount::create(['player_id' => $id, 'view_count' => 1]);
        }
    }

    public function handlePlayerLike($playerId, $userId)
    {
        try {
            $existingLike = Like::where('user_id', $userId)
                ->where('player_id', $playerId)
                ->first();

            if ($existingLike) {
                $existingLike->delete();
                return [
                    'success' => true, 
                    'message' => 'Beğeni geri alındı!',
                    'liked' => false,
                    'likeCount' => $this->getPlayerLikeCount($playerId)
                ];
            }

            Like::create([
                'user_id' => $userId,
                'player_id' => $playerId
            ]);

            return [
                'success' => true, 
                'message' => 'Beğeni başarıyla kaydedildi!',
                'liked' => true,
                'likeCount' => $this->getPlayerLikeCount($playerId)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }

    public function checkIfUserLikedPlayer($playerId, $userId)
    {
        return Like::where('user_id', $userId)
            ->where('player_id', $playerId)
            ->exists();
    }

    public function handleComment($playerId, $userId, $content, $parentId = null)
    {
        try {
            if (empty($content)) {
                return [
                    'success' => false,
                    'message' => 'Yorum içeriği boş olamaz!'
                ];
            }

            if ($parentId) {
                $parentComment = Comment::find($parentId);
                if (!$parentComment) {
                    return [
                        'success' => false,
                        'message' => 'Yanıt vermek istediğiniz yorum bulunamadı!'
                    ];
                }
            }

            $comment = Comment::create([
                'user_id' => $userId,
                'player_id' => $playerId,
                'content' => $content,
                'parent_id' => $parentId
            ]);

            $commentWithUser = Comment::with(['user:id,name'])
                ->find($comment->id);

            return [
                'success' => true,
                'message' => 'Yorum başarıyla eklendi!',
                'comment' => [
                    'id' => $commentWithUser->id,
                    'content' => $commentWithUser->content,
                    'user_name' => $commentWithUser->user->name,
                    'user_id' => $commentWithUser->user_id,
                    'parent_id' => $commentWithUser->parent_id,
                    'created_at' => $commentWithUser->created_at->diffForHumans()
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Yorum eklenirken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }

    public function getPlayerById($id)
    {
        return $this->playerRepository->getPlayerDetailsById($id);
    }

    public function searchPlayersByName($name)
    {
        return $this->playerRepository->getPlayerProfilesByName($name);
    }

    public function searchPlayersByAgeRange($minAge, $maxAge)
    {
        return $this->playerRepository->getPlayerProfilesByAgeRange($minAge, $maxAge);
    }

    public function searchPlayersByPosition($position)
    {
        return $this->playerRepository->getPlayerProfileByMainPosition($position);
    }

    public function searchPlayersByNationality($nationality)
    {
        return $this->playerRepository->getPlayerProfilesByNationality($nationality);
    }

    public function searchPlayersByClub($clubName)
    {
        return $this->playerRepository->getPlayerProfilesByClub($clubName);
    }

    public function searchPlayersByFoot($foot)
    {
        return $this->playerRepository->getPlayerProfilesByFoot($foot);
    }

    public function searchPlayersByFilters($filters)
    {
        return $this->playerRepository->getPlayerProfiles($filters);
    }

    public function searchPlayersByMarketValue($minValue, $maxValue)
    {
        return $this->playerRepository->getPlayerProfilesByMarketValueRange($minValue, $maxValue);
    }

    public function getPlayerProfilesView()
    {
        return $this->playerRepository->getPlayerProfilesView();
    }

    public function getTopLikedPlayer()
    {
        $topPlayer = $this->playerRepository->getPlayerProfilesLikes()->first();
        if (!$topPlayer) {
            return null;
        }

        $topPlayerDetails = $this->playerRepository->getPlayerDetailsById($topPlayer->id);
        return [
            'player_id' => $topPlayerDetails['profile']['id'],
            'image_url' => $topPlayerDetails['profile']['imageURL'],
            'player_name' => $topPlayerDetails['profile']['name']
        ];
    }

    public function getPlayerLikeCount($playerId)
    {
        return Like::where('player_id', $playerId)->count();
    }

    public function getTopPlayer()
    {
        $topPlayer = $this->playerRepository->getTopPlayers();
        if (!$topPlayer) {
            return null;
        }

        $topPlayerDetails = $this->playerRepository->getPlayerDetailsById($topPlayer->player_id);
        return [
            'player_id' => $topPlayer->player_id,
            'image_url' => $topPlayer->image_url,
            'player_name' => $topPlayerDetails['profile']['name']
        ];
    }

    public function deleteComment($commentId, $userId)
    {
        try {
            $comment = Comment::where('id', $commentId)
                ->where('user_id', $userId)
                ->first();

            if (!$comment) {
                return [
                    'success' => false,
                    'message' => 'Yorum bulunamadı veya silme yetkiniz yok!'
                ];
            }

            Comment::where('parent_id', $commentId)->delete();
            $comment->delete();

            return [
                'success' => true,
                'message' => 'Yorum başarıyla silindi!'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Yorum silinirken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }

    public function getPlayerComments($playerId)
    {
        try {
            $comments = Comment::where('player_id', $playerId)
                ->whereNull('parent_id')  // Sadece ana yorumları getir
                ->with(['user:id,name', 'replies.user:id,name'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user_name' => $comment->user->name,
                        'user_id' => $comment->user_id,
                        'created_at' => $comment->created_at->diffForHumans(),
                        'replies' => $comment->replies->map(function ($reply) {
                            return [
                                'id' => $reply->id,
                                'content' => $reply->content,
                                'user_name' => $reply->user->name,
                                'user_id' => $reply->user_id,
                                'created_at' => $reply->created_at->diffForHumans()
                            ];
                        })
                    ];
                });

            return [
                'success' => true,
                'comments' => $comments
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Yorumlar alınırken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }

    // Diğer business logic metodları buraya eklenebilir...
}
