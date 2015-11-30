//
//  PhotoViewDialog.m
//  SMBeacon
//
//  Created by iGold on 3/16/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import "PhotoViewDialog.h"

#import "Global.h"
#import <Haneke.h>
#import "UIViewController+MJPopupViewController.h"

@interface PhotoViewDialog() <UIScrollViewDelegate>
{
    IBOutlet UIScrollView * mScrollView;
    IBOutlet UIImageView * mImageView;
    IBOutlet UIActivityIndicatorView *loadingView;
}

@end

@implementation PhotoViewDialog

- (void) viewDidLoad
{
    [super viewDidLoad];
    
    mScrollView.maximumZoomScale = 100;
    mScrollView.minimumZoomScale = 1;
    [mScrollView setZoomScale:1];
    
    
    mImageView.contentMode = UIViewContentModeScaleAspectFit;

    loadingView.hidden = NO;
    [mImageView hnk_setImageFromURL:[NSURL URLWithString:_imgUrl] placeholder:nil success:^(UIImage *image) {
        loadingView.hidden = YES;
        mImageView.image = image;
    } failure:^(NSError *error) {
        
    }];

    
}
- (IBAction)onClickClose:(id)sender {
    
    if (self.delegate /*&& [self.delegate respondsToSelector:@selector(closeDialog)]*/) {
        [self.delegate closeDialog];
    }
}

- (UIView *)viewForZoomingInScrollView:(UIScrollView *)scrollView
{
    return mImageView;
}

@end
