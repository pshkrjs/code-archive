package com.company;

public class Name {
    private Title title = null;
    private String fName;
    private String mName;
    private String lName;
    public Name(Title title, String fName,
                String mName, String lName) {
        super();
        this.title = title;
        this.fName = fName;
        this.mName = mName;
        this.lName = lName;
    }
    public Title getTitle() {
        return title;
    }
    public void setTitle(Title title) {
        this.title = title;
    }
    public String getfName() {
        return fName;
    }
    public void setfName(String fName) {
        this.fName = fName;
    }
    public String getmName() {
        return mName;
    }
    public void setmName(String mName) {
        this.mName = mName;
    }
    public String getlName() {
        return lName;
    }
    public void setlName(String lName) {
        this.lName = lName;
    }
    @Override
    public int hashCode() {
        final int prime = 31;
        int result = 1;
        result = prime * result + ((fName == null) ? 0 : fName.hashCode());
        result = prime * result + ((lName == null) ? 0 : lName.hashCode());
        result = prime * result + ((mName == null) ? 0 : mName.hashCode());
        return result;
    }
    @Override
    public boolean equals(Object obj) {
        if (this == obj)
            return true;
        if (obj == null)
            return false;
        if (getClass() != obj.getClass())
            return false;
        Name other = (Name) obj;
        if (fName == null) {
            if (other.fName != null)
                return false;
        } else if (!fName.equals(other.fName))
            return false;
        if (lName == null) {
            if (other.lName != null)
                return false;
        } else if (!lName.equals(other.lName))
            return false;
        if (mName == null) {
            if (other.mName != null)
                return false;
        } else if (!mName.equals(other.mName))
            return false;
        return true;
    }
    @Override
    public String toString() {
        StringBuilder builder = new StringBuilder();
        builder.append(title);
        builder.append(" ");
        builder.append(fName);
        builder.append(" ");
        builder.append(mName);
        builder.append(" ");
        builder.append(lName);
        return builder.toString();
    }
}
