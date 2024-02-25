export interface TweetResponse {
  userSession: string;
  data: Tweet[];
}

export interface Tweet {
  id: number;
  content: string;
  author: string;
  createdAt: string;
  retweets: Retweet[];
  comments: Comment[];
  liked: boolean;
  retweeted: boolean;
  likesCount: number;
  commentsCount: number;
}

export interface Retweet {
  id: number;
  tweet: number;
  createdAt: string;
  userId: number;
}

export interface TweetContent {
  content: string;
}

export interface TweetId {
  tweetId: number;
}

export interface CommentContent {
  tweetId: number;
  content: string;
}

export interface CommentComment {
  commentId: number;
  content: string;
}

export interface LikeComment {
  commentId: number;
}

export interface RetweetComment {
  commentId: number;
}

export interface FollowingId {
  followingId: number;
}

export interface Comment {
  id: number;
  author: string;
  content: string;
  parentComment?: number;
  liked: boolean;
  retweeted: boolean;
  likesCount: number;
  commentsCount: number;
  retweetsCount: number;
  createdAt: string;
}
