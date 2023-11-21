class LinksController < ApplicationController
    skip_before_filter  :verify_authenticity_token
    def new
        @link = Link.all
        render :json => {
         :status => :ok, 
         :message => "Success!",
         :data => @link
        }.to_json
    end
    def create
        @link = Link.new(link_params)
        @link.save
        render :json => {
         :status => :ok, 
         :message => "Success!",
         :data => @link
        }.to_json
    end
    def show
        @link = Link.find(params[:id])
        render :json => {
         :status => :ok, 
         :message => "Success!",
         :data => @link
        }.to_json
    end
    private
        def link_params
            params.permit(:url_path)
        end
end
