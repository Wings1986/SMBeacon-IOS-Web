//
//  PhotoViewDialog.h
//  SMBeacon
//
//  Created by iGold on 3/16/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol PhotoViewDialogDelegate<NSObject>
@optional
- (void) closeDialog;
@end

@interface PhotoViewDialog : UIViewController

@property (nonatomic, assign) NSString* imgUrl;

@property (nonatomic, strong) id<PhotoViewDialogDelegate> delegate;

@end


