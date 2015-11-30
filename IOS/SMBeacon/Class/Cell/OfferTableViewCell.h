//
//  OfferTableViewCell.h
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface OfferTableViewCell : UITableViewCell

@property (strong, nonatomic) IBOutlet UIImageView *ivPic;
@property (strong, nonatomic) IBOutlet UIActivityIndicatorView *loadingView;

@property (strong, nonatomic) IBOutlet UILabel *lbTitle;
@property (strong, nonatomic) IBOutlet UILabel *lbDescription;
@property (strong, nonatomic) IBOutlet UIImageView *ivRedeem;

@end
