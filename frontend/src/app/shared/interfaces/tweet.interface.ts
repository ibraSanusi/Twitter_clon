export interface TweetResponse {
  success: boolean;
  data: Tweet[];
}

export interface Tweet {
  id: number;
  content: string;
  author: string;
  publishDate: string;
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
  retweetDate: CreatedAt;
  userId: number;
}

export interface CreatedAt {
  date: string;
  timezone_type: number;
  timezone: string;
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

export interface Comment {
  id: number;
  author: string;
  content: string;
  parentComment: any;
  createdAt: CreatedAt;
}
